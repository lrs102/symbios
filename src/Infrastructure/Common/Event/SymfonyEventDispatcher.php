<?php

namespace App\Infrastructure\Common\Event;

use App\Application\Common\Event\EventDispatcherInterface as AppEventDispatcher;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface as SymfonyEventDispatcherInterface;

final class SymfonyEventDispatcher implements AppEventDispatcher
{
    public function __construct(
        private readonly SymfonyEventDispatcherInterface $dispatcher
    ) {}

    public function dispatch(object $event): void
    {
        $this->dispatcher->dispatch($event);
    }
}
