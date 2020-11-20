<?php

namespace App\Entity;

use App\Repository\HealthCareTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HealthCareTypeRepository::class)
 */
class HealthCareType
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=HealthCare::class, mappedBy="type")
     */
    private $healthCares;

    public function __construct()
    {
        $this->healthCares = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|HealthCare[]
     */
    public function getHealthCares(): Collection
    {
        return $this->healthCares;
    }

    public function addHealthCare(HealthCare $healthCare): self
    {
        if (!$this->healthCares->contains($healthCare)) {
            $this->healthCares[] = $healthCare;
            $healthCare->setType($this);
        }

        return $this;
    }

    public function removeHealthCare(HealthCare $healthCare): self
    {
        if ($this->healthCares->removeElement($healthCare)) {
            // set the owning side to null (unless already changed)
            if ($healthCare->getType() === $this) {
                $healthCare->setType(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
