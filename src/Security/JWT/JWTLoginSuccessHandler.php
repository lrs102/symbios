<?php

namespace App\Security\JWT;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class JWTLoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    private JWTTokenManagerInterface $jwtManager;

    public function __construct(JWTTokenManagerInterface $jwtManager)
    {
        $this->jwtManager = $jwtManager;
    }

    public function handleAuthenticationSuccess(UserInterface $user, Request $request): JsonResponse
    {
        $token = $this->jwtManager->create($user);

        return new JsonResponse([
            'token' => $token,
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'groups' => array_map(fn($g) => $g->getName(), $user->getGroups()->toArray()),
            ]
        ]);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
    {
        // TODO: Implement onAuthenticationSuccess() method.
    }
}
