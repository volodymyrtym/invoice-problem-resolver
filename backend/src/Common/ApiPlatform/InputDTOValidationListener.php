<?php

declare(strict_types=1);

namespace App\Common\ApiPlatform;

use ApiPlatform\Metadata\Resource\Factory\ResourceMetadataCollectionFactoryInterface;
use App\Common\Service\ReflectionClass;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsEventListener(event: 'kernel.request', priority: 10)]
class InputDTOValidationListener
{
    private ResourceMetadataCollectionFactoryInterface $resourceMetadataFactory;

    public function __construct(ResourceMetadataCollectionFactoryInterface $resourceMetadataFactory)
    {
        $this->resourceMetadataFactory = $resourceMetadataFactory;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (
            $request->getContentTypeFormat() !== 'json'
            && $request->getContentTypeFormat() !== 'jsonld'
        ) {
            return;
        }

        $resourceClass = $request->attributes->get('_api_resource_class');
        $operationName = $request->attributes->get('_api_operation_name');

        if (!$resourceClass || !$operationName) {
            return;
        }

        $resourceMetadataCollection = $this->resourceMetadataFactory->create($resourceClass);
        $operation = null;
        foreach ($resourceMetadataCollection as $resourceMetadata) {
            foreach ($resourceMetadata->getOperations() as $op) {
                if ($op->getName() === $operationName) {
                    $operation = $op;
                    break 2;
                }
            }
        }

        if (!$operation) {
            return;
        }

        $inputClass = $operation->getInput()['class'] ?? null;

        if ($inputClass && class_exists($inputClass)) {
            $this->validateOnRequiredButNullable(
                $inputClass,
                json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR),
            );
        }
    }

    private function validateOnRequiredButNullable(string $commandClass, array $data): void
    {
        $reflection = new \ReflectionClass($commandClass);

        foreach ($reflection->getProperties() as $property) {
            $propertyName = $property->getName();
            $type = $property->getType();

            if (!array_key_exists($propertyName, $data)) {
                throw new BadRequestHttpException(sprintf('Field "%s" is required.', $propertyName));
            }

            if ($type && !$type->allowsNull() && $data[$propertyName] === null) {
                throw new BadRequestHttpException(sprintf('Field "%s" cannot be null.', $propertyName));
            }

            // nested object check
            if ($type && !$type->isBuiltin()) {
                $nestedClass = $type->getName();
                if (class_exists($nestedClass) && is_array($data[$propertyName])) {
                    $this->validateOnRequiredButNullable($nestedClass, $data[$propertyName]);
                }
            }
        }
    }
}
