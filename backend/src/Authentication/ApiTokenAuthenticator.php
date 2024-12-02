<?php

declare(strict_types=1);

namespace App\Authentication;

use App\Authentication\ApiToken\TokenHashStorageInterface;
use App\AuthenticationContract\UserApiAuthenticatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class ApiTokenAuthenticator extends AbstractAuthenticator implements UserApiAuthenticatorInterface
{
    public function __construct(
        private string $secretSolt,
        private TokenHashStorageInterface $tokenHashStorage,
        private Security $security,
    ) {}

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): bool
    {
        return !$this->isSessionAuthenticated() && $request->headers->has('auth-token');
    }

    public function authenticate(Request $request): Passport
    {
        $authToken = $request->headers->get('auth-token');
        if (is_null($authToken)) {
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        $hashedTokenFromHeader = hash_hmac('sha256', $authToken, $this->secretSolt);
        $userIdentifier = $this->tokenHashStorage->findUserId($hashedTokenFromHeader);
        if (is_null($userIdentifier)) {
            throw new CustomUserMessageAuthenticationException('Wrong API token provided');
        }

        return new SelfValidatingPassport(new UserBadge($userIdentifier));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        // on success, let the request continue
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        //will never be called as login contrell will handle this
        return null;
    }

    public function allowAuthenticate(string $userId): string
    {
        $authToken = bin2hex(random_bytes(32));
        $hashedAuthToken = hash_hmac('sha256', $authToken, $this->secretSolt);
        $this->tokenHashStorage->save(hash: $hashedAuthToken, userId: $userId, ttlSeconds: 3600 * 8);

        return $authToken;
    }

    private function isSessionAuthenticated(): bool
    {
        //is already authenticated via sessions
        $authenticatedUser = $this->security->getUser();

        return $authenticatedUser !== null;
    }
}
