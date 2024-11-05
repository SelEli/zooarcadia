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

    #[ORM\Column(type: 'blob')]
    private $data;

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

    public function getData()
    {
        return $this->data;
    }

    public function setData($data): static
    {
        $this->data = $data;
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

    public function getAnimal(): ?Animals
    {
        return $this->animal;
    }

    public function setAnimal(?Animals $animal): static
    {
        $this->animal = $animal;
        return $this;
    }
}
