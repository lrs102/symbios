<?php

namespace App\Application\Common\Event;

interface EventDispatcherInterface
{
    public function dispatch(object $event): void;
}
