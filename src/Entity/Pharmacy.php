<?php

namespace App\Entity;

use App\Repository\PharmacyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PharmacyRepository::class)
 */
class Pharmacy
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $points;

    /**
     * @ORM\ManyToOne(targetEntity=Woreda::class, inversedBy="pharmacies")
     * @ORM\JoinColumn(nullable=false)
     */
    private $woreda;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPhoneNumber(): ?int
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?int $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(?string $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getWoreda(): ?Woreda
    {
        return $this->woreda;
    }

    public function setWoreda(?Woreda $woreda): self
    {
        $this->woreda = $woreda;

        return $this;
    }
}
