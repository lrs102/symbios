<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Repository\GroupRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

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
            && $subject instanceof \App\Entity\User;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $currentUser = $token->getUser();

        if (
            !$currentUser instanceof User ||
            !$subject instanceof User ||
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
