<?php

namespace App\Application\User;

use App\Domain\User\Entity\User;
use App\Domain\User\Event\UserCreated;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateUserService
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly MessageBusInterface    $bus
    ) {}

    public function create(array $data): User
    {
        $user = new User();
        $user->setFirstName($data['firstName']);
        $user->setLastName($data['lastName']);
        $user->setEmail($data['email']);
        $user->setPassword(password_hash($data['password'], PASSWORD_BCRYPT));
        $user->setIsActive(true);
        $user->setCreatedAt(new \DateTime());
        $user->setModifiedAt(new \DateTime());

        $this->em->persist($user);
        $this->em->flush();

        $event = new UserCreated($user->getId(), $user->getEmail());
        $this->bus->dispatch($event);

        return $user;
    }
}
