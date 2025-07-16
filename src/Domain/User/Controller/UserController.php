<?php

namespace App\Domain\User\Controller;

use App\Domain\User\Entity\User;
use App\Domain\User\Event\UserCreated;
use App\Domain\User\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $em,
        private MessageBusInterface $bus
    ) {}

    #[Route('/api/v1/users/{id}', name: 'api_v1_fetch_user', methods: ['GET'])]
    public function fetch(Request $request, UserRepository $repository): JsonResponse
    {
        $user = $repository->find($request->get('id'));

        return $this->json([
            'id' => $user->getId(),
            'firstname' => $user->getFirstName(),
            'lastname' => $user->getLastName(),
        ]);
    }

    #[Route('/api/v1/users', name: 'api_v1_create_user', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_EDITOR');
        $data = json_decode($request->getContent(), true);

        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT)); // 🔐 hash password
        $user->setIsActive(true);
        $user->setCreatedAt(new \DateTime());
        $user->setModifiedAt(new \DateTime());

        $em->persist($user);
        $em->flush();

        $event = new UserCreated($user->getId(), $user->getEmail());
        $this->bus->dispatch($event);

        return $this->json([
            'id' => $user->getId(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName(),
        ], 201);
    }
}
