<?php

namespace App\Infrastructure\Messenger;

use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class MessengerDomainEventDispatcher
{
    public function __construct(private MessageBusInterface $bus) {}

    /**
     * @throws ExceptionInterface
     */
    public function dispatchAll(iterable $events): void
    {
        foreach ($events as $event) {
            $this->bus->dispatch($event);
        }
    }
}
