<?php

namespace App\Application\User\DTO;

final class UserData
{
    public function __construct(
        public string | int $id,
        public string $email,
        public string $firstName,
        public string $lastName,
        public string $password,
    ) {}
}
