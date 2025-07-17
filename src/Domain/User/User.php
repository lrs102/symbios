<?php

namespace App\Domain\User;

use App\Application\User\DTO\UserData as UserDTO;

final class User
{
    public function __construct(
        private string $id,
        private string $email,
        private string $firstName,
        private string $lastName,
        private string $password,
        private bool   $isActive = true,
    ) {}

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function deactivate(): void
    {
        $this->isActive = false;
    }

    public static function fromDTO(UserDTO $dto): self
    {
        return new self(
            $dto->id,
            $dto->email,
            $dto->firstName,
            $dto->lastName,
            $dto->password
        );
    }

    public function toDTO(): UserDTO
    {
        return new UserDTO(
            $this->id,
            $this->email,
            $this->firstName,
            $this->lastName,
            $this->password
        );
    }
}
