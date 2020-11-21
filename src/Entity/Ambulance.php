<?php

namespace App\Entity;

use App\Repository\AmbulanceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AmbulanceRepository::class)
 */
class Ambulance
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
    private $plate;

    /**
     * @ORM\ManyToOne(targetEntity=Owner::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $owner;

    /**
     * @ORM\ManyToOne(targetEntity=Woreda::class, inversedBy="ambulances")
     * @ORM\JoinColumn(nullable=false)
     */
    private $primaryLocation;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $gps;

    /**
     * @ORM\OneToMany(targetEntity=AmbulanceDriver::class, mappedBy="ambulance")
     */
    private $ambulanceDrivers;

    /**
     * @ORM\Column(type="integer")
     */
    private $status;

    public function __construct()
    {
        $this->ambulanceDrivers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlate(): ?string
    {
        return $this->plate;
    }

    public function setPlate(string $plate): self
    {
        $this->plate = $plate;

        return $this;
    }

    public function getOwner(): ?Owner
    {
        return $this->owner;
    }

    public function setOwner(?Owner $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getPrimaryLocation(): ?Woreda
    {
        return $this->primaryLocation;
    }

    public function setPrimaryLocation(?Woreda $primaryLocation): self
    {
        $this->primaryLocation = $primaryLocation;

        return $this;
    }

    public function getGps(): ?string
    {
        return $this->gps;
    }

    public function setGps(?string $gps): self
    {
        $this->gps = $gps;

        return $this;
    }

    /**
     * @return Collection|AmbulanceDriver[]
     */
    public function getAmbulanceDrivers(): Collection
    {
        return $this->ambulanceDrivers;
    }

    public function addAmbulanceDriver(AmbulanceDriver $ambulanceDriver): self
    {
        if (!$this->ambulanceDrivers->contains($ambulanceDriver)) {
            $this->ambulanceDrivers[] = $ambulanceDriver;
            $ambulanceDriver->setAmbulance($this);
        }

        return $this;
    }

    public function removeAmbulanceDriver(AmbulanceDriver $ambulanceDriver): self
    {
        if ($this->ambulanceDrivers->removeElement($ambulanceDriver)) {
            // set the owning side to null (unless already changed)
            if ($ambulanceDriver->getAmbulance() === $this) {
                $ambulanceDriver->setAmbulance(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }  

    public function __toString()
    {
        return $this->plate;
    }
}
