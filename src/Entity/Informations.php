<?php

namespace App\Entity;

use App\Repository\InformationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InformationsRepository::class)]
class Informations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $contactAddress = null;

    #[ORM\Column(length: 255)]
    private ?string $contactPhone = null;

    #[ORM\Column(length: 255)]
    private ?string $contactEmail = null;

    #[ORM\Column(length: 255)]
    private ?string $openingDays = null;

    #[ORM\Column(length: 255)]
    private ?string $openingHours = null;

    #[ORM\Column(length: 255)]
    private ?string $adultPrice = null;

    #[ORM\Column(length: 255)]
    private ?string $childPrice = null;

    #[ORM\Column(length: 255)]
    private ?string $toddlerPrice = null;

    #[ORM\Column(length: 255)]
    private ?string $familyPrice = null;

    #[ORM\Column(length: 255)]
    private ?string $groupPrice = null;

    #[ORM\Column(length: 255)]
    private ?string $parkingInfo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactAddress(): ?string
    {
        return $this->contactAddress;
    }

    public function setContactAddress(string $contactAddress): static
    {
        $this->contactAddress = $contactAddress;

        return $this;
    }

    public function getContactPhone(): ?string
    {
        return $this->contactPhone;
    }

    public function setContactPhone(string $contactPhone): static
    {
        $this->contactPhone = $contactPhone;

        return $this;
    }

    public function getContactEmail(): ?string
    {
        return $this->contactEmail;
    }

    public function setContactEmail(string $contactEmail): static
    {
        $this->contactEmail = $contactEmail;

        return $this;
    }

    public function getOpeningDays(): ?string
    {
        return $this->openingDays;
    }

    public function setOpeningDays(string $openingDays): static
    {
        $this->openingDays = $openingDays;

        return $this;
    }

    public function getOpeningHours(): ?string
    {
        return $this->openingHours;
    }

    public function setOpeningHours(string $openingHours): static
    {
        $this->openingHours = $openingHours;

        return $this;
    }

    public function getAdultPrice(): ?string
    {
        return $this->adultPrice;
    }

    public function setAdultPrice(string $adultPrice): static
    {
        $this->adultPrice = $adultPrice;

        return $this;
    }

    public function getChildPrice(): ?string
    {
        return $this->childPrice;
    }

    public function setChildPrice(string $childPrice): static
    {
        $this->childPrice = $childPrice;

        return $this;
    }

    public function getToddlerPrice(): ?string
    {
        return $this->toddlerPrice;
    }

    public function setToddlerPrice(string $toddlerPrice): static
    {
        $this->toddlerPrice = $toddlerPrice;

        return $this;
    }

    public function getFamilyPrice(): ?string
    {
        return $this->familyPrice;
    }

    public function setFamilyPrice(string $familyPrice): static
    {
        $this->familyPrice = $familyPrice;

        return $this;
    }

    public function getGroupPrice(): ?string
    {
        return $this->groupPrice;
    }

    public function setGroupPrice(string $groupPrice): static
    {
        $this->groupPrice = $groupPrice;

        return $this;
    }

    public function getParkingInfo(): ?string
    {
        return $this->parkingInfo;
    }

    public function setParkingInfo(string $parkingInfo): static
    {
        $this->parkingInfo = $parkingInfo;

        return $this;
    }
}
