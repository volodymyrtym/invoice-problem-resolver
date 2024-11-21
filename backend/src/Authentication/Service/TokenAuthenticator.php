<?php

declare(strict_types=1);

namespace App\Authentication\Service;

use App\Authentication\Storage\TokenHashStorage;
use App\User\UseCase\Login\UserAuthenticator;
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

final class TokenAuthenticator extends AbstractAuthenticator implements UserAuthenticator
{
    public function __construct(private string $secretSolt, private TokenHashStorage $tokenHashStorage) {}

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): bool
    {
        return $request->headers->has('auth-token');
    }

    public function authenticate(Request $request): Passport
    {
        $authToken = $request->headers->get('auth-token');
        if (is_null($authToken)) {
            throw new CustomUserMessageAuthenticationException('No API token provided');
        }

        $hashedTokenFromHeader = hash_hmac('sha256', $authToken, $this->secretSolt);
        $userIdentifier = $this->tokenHashStorage->find($hashedTokenFromHeader);
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
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData()),

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }

    public function allowAuthenticateForUser(string $userId): string
    {
        $authToken = bin2hex(random_bytes(32));
        $hashedAuthToken = hash_hmac('sha256', $authToken, $this->secretSolt);
        $this->tokenHashStorage->save(hash: $hashedAuthToken, userId: $userId, ttlSeconds: 3600 * 8);

        return $authToken;
    }
}
