<?php

namespace App\Domain\Authentication\Event\Listener;

use App\Infrastructure\Persistance\Doctrine\User\Entity\UserEntity;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class JWTCreatedListener
{
    public function __invoke(JWTCreatedEvent $event): void
    {
        $user = $event->getUser();

        if (!$user instanceof UserEntity) {
            return;
        }

        $payload = $event->getData();
        $payload['id'] = $user->getId();
        $payload['email'] = $user->getEmail();
        $payload['groups'] = array_map(fn($g) => $g->getName(), $user->getGroups()->toArray());

        $event->setData($payload);
    }
}

