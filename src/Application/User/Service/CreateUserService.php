<?php

namespace App\Application\User\Service;

use App\Domain\User\Repository\UserRepositoryInterface;
use App\Domain\User\User;

class CreateUserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function createUser(array $data): void
    {
        $user = new User($data['email'], $data['password']);
        $this->userRepository->($user);
    }
}
