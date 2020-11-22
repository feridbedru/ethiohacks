<?php

namespace App\Entity;

use App\Repository\HealthCareFacilityRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HealthCareFacilityRepository::class)
 */
class HealthCareFacility
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=HealthCare::class, inversedBy="healthCareFacilities")
     * @ORM\JoinColumn(nullable=false)
     */
    private $healthcare;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHealthcare(): ?HealthCare
    {
        return $this->healthcare;
    }

    public function setHealthcare(?HealthCare $healthcare): self
    {
        $this->healthcare = $healthcare;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
