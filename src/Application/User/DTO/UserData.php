<?php

namespace App\Application\User\DTO;

final class UserData
{
    public function __construct(
        public string $email,
        public string $firstName,
        public string $lastName,
        public string $password,
    ) {}
}
