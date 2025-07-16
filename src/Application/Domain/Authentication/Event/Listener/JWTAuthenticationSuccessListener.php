<?php

namespace App\Application\Domain\Authentication\Event\Listener;

use App\Application\Domain\User\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class JWTAuthenticationSuccessListener
{
    public function __invoke(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData(); // Contains 'token'
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $data['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'groups' => array_map(fn($g) => $g->getName(), $user->getGroups()->toArray()),
        ];

        $event->setData($data);
    }
}
