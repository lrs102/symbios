<?php

namespace App\Application\User\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

readonly class UpdateUserService
{
    public function __construct(
        private EntityManagerInterface $em,
        private MessageBusInterface    $bus
    ) {}

    public function update(int $id, array $data)
    {
//        $user = $this->em->
    }
}
