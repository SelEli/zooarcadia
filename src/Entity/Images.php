<?php

namespace App\Entity;

use App\Repository\ImagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImagesRepository::class)]
class Images
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BLOB)]
    private $data;

    /**
     * @var Collection<int, Habitats>
     */
    #[ORM\OneToMany(targetEntity: Habitats::class, mappedBy: 'image')]
    private Collection $habitats;

    /**
     * @var Collection<int, Animals>
     */
    #[ORM\OneToMany(targetEntity: Animals::class, mappedBy: 'image')]
    private Collection $animals;

    public function __construct()
    {
        $this->habitats = new ArrayCollection();
        $this->animals = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Habitats>
     */
    public function getHabitats(): Collection
    {
        return $this->habitats;
    }

    public function addHabitat(Habitats $habitat): static
    {
        if (!$this->habitats->contains($habitat)) {
            $this->habitats->add($habitat);
            $habitat->setImage($this);
        }

        return $this;
    }

    public function removeHabitat(Habitats $habitat): static
    {
        if ($this->habitats->removeElement($habitat)) {
            // set the owning side to null (unless already changed)
            if ($habitat->getImage() === $this) {
                $habitat->setImage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Animals>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animals $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setImage($this);
        }

        return $this;
    }

    public function removeAnimal(Animals $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getImage() === $this) {
                $animal->setImage(null);
            }
        }

        return $this;
    }
}
