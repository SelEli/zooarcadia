<?php

namespace App\Entity;

use App\Repository\AnimalsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalsRepository::class)]
class Animals
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $state = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Habitats $habitat = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Images $image = null;

    #[ORM\ManyToOne(targetEntity: Races::class, inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Races $race = null;

    #[ORM\Column(type: 'integer')]
    private int $clicks = 0;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $details = null;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;
        return $this;
    }

    public function getHabitat(): ?Habitats
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitats $habitat): static
    {
        $this->habitat = $habitat;
        return $this;
    }

    public function getImage(): ?Images
    {
        return $this->image;
    }

    public function setImage(?Images $image): static
    {
        $this->image = $image;
        return $this;
    }

    public function getRace(): ?Races
    {
        return $this->race;
    }

    public function setRace(?Races $race): static
    {
        $this->race = $race;
        return $this;
    }

    public function getClicks(): int
    {
        return $this->clicks;
    }

    public function incrementClicks(): static
    {
        $this->clicks++;
        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): static
    {
        $this->details = $details;
        return $this;
    }
}
