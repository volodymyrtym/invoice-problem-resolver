<?php

namespace App\User\UseCase\Login;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LoginController extends AbstractController
{

    public function __construct(private LoginHandler $loginHandler) {

    }

    #[Route('/login')]
    public function index(Request $request): Response
    {
        $email = $request->get('email', '');
        $password = $request->get('password', '');

        $this->loginHandler->handler($email, $password);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ApiLoginController.php',
        ]);
    }
}
