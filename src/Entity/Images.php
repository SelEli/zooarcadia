<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $filename = null;

    #[ORM\ManyToOne(targetEntity: Habitats::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Habitats $habitat = null;

    #[ORM\ManyToOne(targetEntity: Animals::class, inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Animals $animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;
        return $this;
    }

    public function getHabitat(): ?Habitats
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitats $habitat): self
    {
        $this->habitat = $habitat;
        return $this;
    }

    public function getAnimal(): ?Animals
    {
        return $this->animal;
    }

    public function setAnimal(?Animals $animal): self
    {
        $this->animal = $animal;
        return $this;
    }

    public function __toString(): string
    {
        return $this->filename ? $this->filename : '';
    }
}
