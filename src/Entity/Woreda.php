<?php

namespace App\Entity;

use App\Repository\WoredaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=WoredaRepository::class)
 */
class Woreda
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
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
     * @ORM\Column(type="text", nullable=true)
     */
    private $points;

    /**
     * @ORM\ManyToOne(targetEntity=Zone::class, inversedBy="woredas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $zone;

    /**
     * @ORM\OneToMany(targetEntity=HealthCare::class, mappedBy="woreda")
     */
    private $healthCares;

    /**
     * @ORM\OneToMany(targetEntity=Pharmacy::class, mappedBy="woreda")
     */
    private $pharmacies;

    /**
     * @ORM\OneToMany(targetEntity=FireFighter::class, mappedBy="woreda")
     */
    private $fireFighters;

    /**
     * @ORM\OneToMany(targetEntity=Ambulance::class, mappedBy="primaryLocation")
     */
    private $ambulances;

    public function __construct()
    {
        $this->healthCares = new ArrayCollection();
        $this->pharmacies = new ArrayCollection();
        $this->fireFighters = new ArrayCollection();
        $this->ambulances = new ArrayCollection();
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

    public function getPoints(): ?string
    {
        return $this->points;
    }

    public function setPoints(?string $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
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
            $healthCare->setWoreda($this);
        }

        return $this;
    }

    public function removeHealthCare(HealthCare $healthCare): self
    {
        if ($this->healthCares->removeElement($healthCare)) {
            // set the owning side to null (unless already changed)
            if ($healthCare->getWoreda() === $this) {
                $healthCare->setWoreda(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Pharmacy[]
     */
    public function getPharmacies(): Collection
    {
        return $this->pharmacies;
    }

    public function addPharmacy(Pharmacy $pharmacy): self
    {
        if (!$this->pharmacies->contains($pharmacy)) {
            $this->pharmacies[] = $pharmacy;
            $pharmacy->setWoreda($this);
        }

        return $this;
    }

    public function removePharmacy(Pharmacy $pharmacy): self
    {
        if ($this->pharmacies->removeElement($pharmacy)) {
            // set the owning side to null (unless already changed)
            if ($pharmacy->getWoreda() === $this) {
                $pharmacy->setWoreda(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|FireFighter[]
     */
    public function getFireFighters(): Collection
    {
        return $this->fireFighters;
    }

    public function addFireFighter(FireFighter $fireFighter): self
    {
        if (!$this->fireFighters->contains($fireFighter)) {
            $this->fireFighters[] = $fireFighter;
            $fireFighter->setWoreda($this);
        }

        return $this;
    }

    public function removeFireFighter(FireFighter $fireFighter): self
    {
        if ($this->fireFighters->removeElement($fireFighter)) {
            // set the owning side to null (unless already changed)
            if ($fireFighter->getWoreda() === $this) {
                $fireFighter->setWoreda(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ambulance[]
     */
    public function getAmbulances(): Collection
    {
        return $this->ambulances;
    }

    public function addAmbulance(Ambulance $ambulance): self
    {
        if (!$this->ambulances->contains($ambulance)) {
            $this->ambulances[] = $ambulance;
            $ambulance->setPrimaryLocation($this);
        }

        return $this;
    }

    public function removeAmbulance(Ambulance $ambulance): self
    {
        if ($this->ambulances->removeElement($ambulance)) {
            // set the owning side to null (unless already changed)
            if ($ambulance->getPrimaryLocation() === $this) {
                $ambulance->setPrimaryLocation(null);
            }
        }

        return $this;
    }
}
