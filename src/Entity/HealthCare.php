<?php

namespace App\Entity;

use App\Repository\HealthCareRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HealthCareRepository::class)
 */
class HealthCare
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $points;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToOne(targetEntity=HealthCareType::class, inversedBy="healthCares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=Woreda::class, inversedBy="healthCares")
     * @ORM\JoinColumn(nullable=false)
     */
    private $woreda;

    /**
     * @ORM\OneToMany(targetEntity=HealthCareFacility::class, mappedBy="healthcare")
     */
    private $healthCareFacilities;

    public function __construct()
    {
        $this->healthCareFacilities = new ArrayCollection();
    }

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

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(?string $points): self
    {
        $this->points = $points;

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

    public function getType(): ?HealthCareType
    {
        return $this->type;
    }

    public function setType(?HealthCareType $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

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

    /**
     * @return Collection|HealthCareFacility[]
     */
    public function getHealthCareFacilities(): Collection
    {
        return $this->healthCareFacilities;
    }

    public function addHealthCareFacility(HealthCareFacility $healthCareFacility): self
    {
        if (!$this->healthCareFacilities->contains($healthCareFacility)) {
            $this->healthCareFacilities[] = $healthCareFacility;
            $healthCareFacility->setHealthcare($this);
        }

        return $this;
    }

    public function removeHealthCareFacility(HealthCareFacility $healthCareFacility): self
    {
        if ($this->healthCareFacilities->removeElement($healthCareFacility)) {
            // set the owning side to null (unless already changed)
            if ($healthCareFacility->getHealthcare() === $this) {
                $healthCareFacility->setHealthcare(null);
            }
        }

        return $this;
    }

    

    public function __toString()
    {
        return $this->name;
    }
}
