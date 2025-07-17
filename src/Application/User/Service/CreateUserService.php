<?php

namespace App\Application\User\Service;

use App\Application\Common\Event\EventDispatcherInterface;
use App\Application\User\DTO\UserData;
use App\Domain\User\Event\UserCreated;
use App\Domain\User\User;

final class CreateUserService
{
    public function __construct(
        // ...
        private readonly EventDispatcherInterface $eventDispatcher,
    ) {}

    public function create(UserData $dto): User
    {
        $user = new User(
            $dto->id,
            $dto->email,
            $dto->firstName,
            $dto->lastName,
            $dto->password,
        );

        $this->eventDispatcher->dispatch(new UserCreated($user));

        return $user;
    }
}
