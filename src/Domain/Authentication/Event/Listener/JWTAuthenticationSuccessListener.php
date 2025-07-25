<?php

namespace App\Domain\Authentication\Event\Listener;

use App\Infrastructure\Persistance\Doctrine\User\Entity\UserEntity;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

#[AsEventListener]
class JWTAuthenticationSuccessListener
{
    public function __invoke(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData(); // Contains 'token'
        $user = $event->getUser();

        if (!$user instanceof UserEntity) {
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
