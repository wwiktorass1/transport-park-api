<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Driver
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(['fleet:read'])]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['fleet:read'])]
    private string $firstName;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['fleet:read'])]
    private string $lastName;

    #[ORM\Column(type: "string", length: 255)]
    private string $licenseNumber;

    #[ORM\ManyToMany(targetEntity: FleetSet::class, mappedBy: "drivers")]
    private Collection $fleetSets;

    public function __construct()
    {
        $this->fleetSets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getLicenseNumber(): ?string
    {
        return $this->licenseNumber;
    }

    public function setLicenseNumber(string $licenseNumber): self
    {
        $this->licenseNumber = $licenseNumber;
        return $this;
    }

    public function getFleetSets(): Collection
    {
        return $this->fleetSets;
    }

    public function addFleetSet(FleetSet $fleetSet): self
    {
        if (!$this->fleetSets->contains($fleetSet)) {
            $this->fleetSets[] = $fleetSet;
            $fleetSet->addDriver($this);
        }
        return $this;
    }

    public function removeFleetSet(FleetSet $fleetSet): self
    {
        if ($this->fleetSets->contains($fleetSet)) {
            $this->fleetSets->removeElement($fleetSet);
            $fleetSet->removeDriver($this);
        }
        return $this;
    }

    #[Groups(['fleet:read'])]
    public function getName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    public function setName(string $name): self
    {
        [$first, $last] = explode(' ', $name, 2);
        $this->firstName = $first;
        $this->lastName = $last ?? '';
        return $this;
    }
}
