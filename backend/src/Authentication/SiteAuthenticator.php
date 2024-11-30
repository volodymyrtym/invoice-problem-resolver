<?php

declare(strict_types=1);

namespace App\Authentication;

use App\AuthenticationContract\UserApiAuthenticatorInterface;
use App\AuthenticationContract\UserSessionAuthenticatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class SiteAuthenticator extends AbstractAuthenticator implements UserSessionAuthenticatorInterface
{
    public const string USER_SESSION_KEY = 'userId';

    public function __construct(private RequestStack $requestStack) {}

    public function allowAuthenticate(string $userId): void
    {
        $this->requestStack->getSession()->set(self::USER_SESSION_KEY, $userId);
    }

    public function supports(Request $request): ?bool
    {
        return $this->isSessionAuthenticated();
    }

    public function authenticate(Request $request): Passport
    {
        return new SelfValidatingPassport(new UserBadge($this->getUserIdFromSession()));
    }

   public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName,
    ): ?Response {
       return null;  //will never be called as login contrell will handle this
    }

    public function onAuthenticationFailure(
        Request $request,
        AuthenticationException $exception,
    ): ?Response {
       return null; //will never be called as login contrell will handle this
    }

    private function isSessionAuthenticated(): bool
    {
        return $this->getUserIdFromSession() !== null;
    }

    private function getUserIdFromSession(): null|string
    {
       return $this->requestStack->getSession()->get(self::USER_SESSION_KEY);
    }
}
