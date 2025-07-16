<?php

namespace App\Domain\User\Event;

use App\Domain\Event\DomainEvent;
use function Symfony\Component\Clock\now;

final readonly class UserCreated implements DomainEvent
{
    public function __construct(
        public string $userId,
        public string $email
    ) {}

    /**
     * @throws \DateMalformedStringException
     */
    public function occurredAt(): \DateTimeImmutable
    {
        return now();
    }
}
