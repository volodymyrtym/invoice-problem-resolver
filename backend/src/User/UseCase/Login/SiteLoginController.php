<?php

declare(strict_types=1);

namespace App\User\UseCase\Login;

use App\AuthenticationContract\UserSessionAuthenticatorInterface;
use App\Common\Exception\InvalidInputException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SiteLoginController extends AbstractController
{
    public function __construct(
        private LoginHandler $handler,
        private UserSessionAuthenticatorInterface $authenticator,
    ) {}

    #[Route(path: '/', methods: ['GET'])]
    #[Route(path: '/login', methods: ['GET'])]
    public function loginDisplay(Request $request): Response
    {
        return $this->render('login/login.twig');
    }

    //todo csrf protection
    #[Route(path: '/login_check', methods: ['POST'])]
    public function loginHandle(Request $request): Response
    {
        try {
            $userId = $this->handler->handle(
                new LoginCommand(
                    password: $request->toArray()['password'] ?? '', email: $request->toArray()['email'] ?? '',
                ),
            );
        } catch (InvalidInputException $exception) {
            return new JsonResponse(
                [
                    'error' => true,
                    'detail' => $exception->getMessage(),
                ],
                Response::HTTP_BAD_REQUEST,
            );
        }

        $this->authenticator->allowAuthenticate($userId);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }
}
