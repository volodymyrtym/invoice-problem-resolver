<?php

declare(strict_types=1);

namespace App\Authentication;

use App\Common\Exception\InvalidInputException;
use Symfony\Bundle\SecurityBundle\Security;

final readonly class RequestUserIdProviderImpl implements RequestUserIdProvider
{
    public function __construct(
        private Security $security,
    ) {}

    public function getUserOrDennyRequest(): string
    {
        if (is_null($this->security->getUser())) {
            throw new InvalidInputException('Wrong user');
        }

        return $this->security->getUser()->getUserIdentifier();
    }
}
