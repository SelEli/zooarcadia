<?php

namespace App\Entity;

use App\Repository\HabitatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitatsRepository::class)]
class Habitats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $comment = null;

    /**
     * @var Collection<int, Animals>
     */
    #[ORM\OneToMany(targetEntity: Animals::class, mappedBy: 'habitat')]
    private Collection $animals;

    /**
     * @var Collection<int, Images>
     */
    #[ORM\OneToMany(mappedBy: 'habitat', targetEntity: Images::class)]
    private Collection $images;

    #[ORM\ManyToOne(inversedBy: 'habitats')]
    private ?Images $image = null;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

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

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): static
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return Collection<int, Animals>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }


    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
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


}
