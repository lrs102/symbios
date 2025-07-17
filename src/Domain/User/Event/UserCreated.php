<?php

namespace App\Domain\User\Event;

use App\Domain\User\User;

final readonly class UserCreated
{
    public function __construct(
        private readonly User $user
    ) {}

    public function getUser(): User
    {
        return $this->user;
    }
}
