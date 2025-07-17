<?php

namespace App\Domain\User\Controller;

use App\Application\User\Service\CreateUserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/api/v1/users', name: 'api_v1_create_user', methods: ['POST'])]
    public function create(Request $request, CreateUserService $service): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');

        $data = json_decode($request->getContent(), true);
        $user = $service->create($data);

        return $this->json([
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
        ], 201);
    }
}
