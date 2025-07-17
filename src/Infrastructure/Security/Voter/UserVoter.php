<?php

namespace App\Infrastructure\Security\Voter;

use App\Domain\Group\Repository\GroupRepository;
use App\Infrastructure\Persistance\Doctrine\User\Entity\UserEntity;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class UserVoter extends Voter
{
    public const EDIT = 'POST_EDIT';
    public const VIEW = 'POST_VIEW';

    private GroupRepository $groupRepository;

    public function __construct(GroupRepository $groupRepository)
    {
        $this->groupRepository = $groupRepository;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof \App\Infrastructure\Persistance\Doctrine\User\Entity\UserEntity;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $currentUser = $token->getUser();

        if (
            !$currentUser instanceof UserEntity ||
            !$subject instanceof UserEntity ||
            $currentUser !== $subject
        ) {
            return false;
        }

        return match ($attribute) {
            'CREATE' => (
                $currentUser->hasGroupName('superuser') ||
                $currentUser->hasGroupName('admin')
            ),

            'EDIT' => (
                $currentUser->hasGroupName('superuser') ||
                $currentUser->hasGroupName('admin') ||
                $currentUser->hasGroupName('manager')
            ),

            'DELETE' => (
                $currentUser->hasGroupName('admin') ||
                $currentUser->hasGroupName('superuser')
            ),

            'VIEW' => (
                $currentUser->hasGroupName('superuser') ||
                $currentUser->hasGroupName('admin') ||
                $currentUser->hasGroupName('employee') ||
                $currentUser->hasGroupName('finance') ||
                $currentUser->hasGroupName('marketing') ||
                $currentUser->hasGroupName('manager')
            ),

            default => false,
        };
    }
}
