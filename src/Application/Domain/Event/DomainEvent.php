<?php

namespace App\Application\Domain\Event;

interface DomainEvent
{
    public function occurredAt(): \DateTimeImmutable;
}
