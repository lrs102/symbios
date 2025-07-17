<?php

namespace App\Infrastructure\User\EventListener;

use App\Domain\User\Event\UserCreated;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class UserCreatedListener implements EventSubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface $logger, // Or any service you want injected
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            UserCreated::class => 'onUserCreated',
        ];
    }

    public function onUserCreated(UserCreated $event): void
    {
        $user = $event->getUser();

        // Example side effect: log, send email, etc.
        $this->logger->info('User created: '.$user->getId());

        // Other logic: queue a welcome email, etc.
    }
}

