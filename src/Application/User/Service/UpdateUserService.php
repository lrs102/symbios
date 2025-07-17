<?php

namespace App\Application\User\Service;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;

class UpdateUserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function updateUser(int $id, array $data): void
    {
        /** @var User $user */
        $user = $this->userRepository->findById($id);

        if (!$user) {
            throw new \DomainException("User not found");
        }

        $user->setEmail($data['email'] ?? $user->getEmail());
        $user->setName($data['name'] ?? $user->getName());

        if (!filter_var($user->getEmail(), FILTER_VALIDATE_EMAIL)) {
            throw new \DomainException("Invalid email format");
        }

        $this->userRepository->save($user);
    }
}

