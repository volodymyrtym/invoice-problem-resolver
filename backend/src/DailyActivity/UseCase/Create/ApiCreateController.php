<?php

declare(strict_types=1);

namespace App\DailyActivity\UseCase\Create;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\AuthenticationContract\CurentUserProviderInterface;
use App\Common\Exception\InvalidInputException;
use Webmozart\Assert\Assert;

final readonly class ApiCreateController implements ProcessorInterface
{
    public function __construct(
        private CreateHandler $handler,
        private CurentUserProviderInterface $userProvider,
    ) {}

    /**
     * @throws InvalidInputException
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): void
    {
        Assert::isInstanceOf($data, ApiCreateRequest::class);
        /** @var ApiCreateRequest $data */

        $this->handler->handle(
            new CreateCommand(
                userId: $this->userProvider->provideId(),
                start: $this->createValidDateTime($data->date, $data->dateTimeFrom),
                end: $this->createValidDateTime($data->date, $data->dateTimeTo),
                description: $data->description,
            ),
        );
    }

    private function createValidDateTime(string $date, string $time): \DateTimeImmutable
    {
        try {
            $datetimeString = $date . ' ' . $time;
            $datetime = new \DateTimeImmutable($datetimeString);
            if ($datetime->format('Y-m-d H:i') === "$date $time") {
                return $datetime;
            }

            throw new InvalidInputException('Wrong date format');
        } catch (\Exception $e) {
            throw new InvalidInputException('Wrong date format');
        }
    }
}
