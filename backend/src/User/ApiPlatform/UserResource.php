<?php

declare(strict_types=1);

namespace App\User\ApiPlatform;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\User\UseCase\CreateUser\CreateCommand;
use App\User\UseCase\CreateUser\CreateController;
use App\User\UseCase\Login\LoginCommand;
use App\User\UseCase\Login\ApiLoginController;
use App\User\UseCase\Login\LoginResult;

#[ApiResource(
    uriTemplate: '/users',
    operations: [
        new Post(
            uriTemplate: '/users/register',
            status: 201,
            description: 'Creates user',
            input: CreateCommand::class,
            output: null,
            processor: CreateController::class,
        ),
        new Put(
            uriTemplate: '/users/login',
            status: 200,
            description: 'Login user',
            input: LoginCommand::class,
            output: LoginResult::class,
            processor: ApiLoginController::class,
        ),
    ],
)]
final class UserResource
{
    public function __construct() {}
}
