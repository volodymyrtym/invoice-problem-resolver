<?php

declare(strict_types=1);

namespace App\User\ApiPlatform;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use App\User\UseCase\CreateUser\CreateCommand;
use App\User\UseCase\CreateUser\CreateController;
use App\User\UseCase\Login\LoginCommand;
use App\User\UseCase\Login\LoginController;
use App\User\UseCase\Login\LoginResult;

#[ApiResource(
    uriTemplate: '/users',
    operations: [
        new Post(
            status: 201,
            description: 'Creates user',
            input: CreateCommand::class,
            output: null,
            processor: CreateController::class,
        ),
        new Post(
            uriTemplate: '/users/login',
            status: 200,
            description: 'Login user',
            input: LoginCommand::class,
            output: LoginResult::class,
            processor: LoginController::class,
        ),
    ],
)]
final class UserResource
{
    public function __construct() {}
}
