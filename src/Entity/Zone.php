<?php

namespace App\Entity;

use App\Repository\ZoneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ZoneRepository::class)
 */
class Zone
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
     * @ORM\ManyToOne(targetEntity=Region::class, inversedBy="zones")
     * @ORM\JoinColumn(nullable=false)
     */
    private $region;

    /**
     * @ORM\OneToMany(targetEntity=Woreda::class, mappedBy="zone")
     */
    private $woredas;

    public function __construct()
    {
        $this->woredas = new ArrayCollection();
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

    public function setPoints(string $points): self
    {
        $this->points = $points;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return Collection|Woreda[]
     */
    public function getWoredas(): Collection
    {
        return $this->woredas;
    }

    public function addWoreda(Woreda $woreda): self
    {
        if (!$this->woredas->contains($woreda)) {
            $this->woredas[] = $woreda;
            $woreda->setZone($this);
        }

        return $this;
    }

    public function removeWoreda(Woreda $woreda): self
    {
        if ($this->woredas->contains($woreda)) {
            $this->woredas->removeElement($woreda);
            // set the owning side to null (unless already changed)
            if ($woreda->getZone() === $this) {
                $woreda->setZone(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }
}
