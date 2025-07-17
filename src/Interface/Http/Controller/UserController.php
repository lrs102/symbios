<?php

namespace App\Interface\Http\Controller;

use App\Application\User\DTO\UserData;
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

        $dto = new UserData(
            $data['id'] ?? '',
            $data['email'] ?? '',
            $data['firstName'] ?? '',
            $data['lastName'] ?? '',
            $data['password'] ?? '',
        );

        $user = $service->create($dto);

        return $this->json([
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
        ], 201);
    }
}
