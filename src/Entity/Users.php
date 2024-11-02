<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?UsersRoles $role = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getRole(): ?UsersRoles
    {
        return $this->role;
    }

    public function setRole(?UsersRoles $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function getEntityManagerInterface(): ?string
    {
        return $this->EntityManagerInterface;
    }

    public function setEntityManagerInterface(string $EntityManagerInterface): static
    {
        $this->EntityManagerInterface = $EntityManagerInterface;

        return $this;
    }
}
