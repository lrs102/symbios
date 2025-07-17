<?php

namespace App\Domain\User\Entity;

use App\Domain\Group\Entity\Group;
use App\Infrastructure\Persistance\Doctrine\User\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    #[Assert\Email]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?\DateTime $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTime $modifiedAt = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\ManyToMany(targetEntity: Group::class, inversedBy: 'users')]
    #[ORM\JoinTable(name: 'user_group')]
    private Collection $groups;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function getModifiedAt(): ?\DateTime
    {
        return $this->modifiedAt;
    }

    public function isActive(): ?bool
    {
        return $this->isActive;
    }

    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function hasGroup(Group $group): bool
    {
        return ($this->groups->contains($group));
    }

    public function hasGroupName(string $name): bool
    {
        foreach ($this->groups as $group) {
            if ($group->getName() === $name) {
                return true;
            }
        }
        return false;
    }

    public function getRoles(): array
    {
        $roles = [];

        foreach ($this->groups as $group) {
            $roles[] = 'ROLE_' . strtoupper($group->getName());
        }

        // Guarantee at least one role (Symfony requires it)
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

}
