<?php

namespace App\Infrastructure\Common\Event;

use App\Application\Common\Event\EventDispatcherInterface as AppEventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcherInterface;

final readonly class SymfonyEventDispatcher implements AppEventDispatcher
{
    public function __construct(
        private SymfonyEventDispatcherInterface $dispatcher
    ) {}

    public function dispatch(object $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
