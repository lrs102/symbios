<?php
namespace App\Infrastructure\Persistance\Doctrine\User\Repository;

use App\Domain\User\User;
use App\Domain\User\Repository\UserRepositoryInterface;
use App\Infrastructure\Persistance\Doctrine\User\Entity\UserEntity;
use Doctrine\ORM\EntityManagerInterface;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private EntityManagerInterface $em) {}

    public function findById(string|int $id): ?User
    {
        $entity = $this->em->getRepository(UserEntity::class)->find($id);
        return $entity?->toDomain();
    }

    public function save(User $user): void
    {
        $entity = UserEntity::fromDomain($user);
        $this->em->persist($entity);
        $this->em->flush();
    }

    public function findByEmail(string $email): ?User
    {
        $entity = $this->em->getRepository(UserEntity::class)->findOneBy(['email' => $email]);
        return $entity?->toDomain();
    }
}
