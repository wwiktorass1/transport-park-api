<?php

namespace App\Entity;

use App\Repository\TruckRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TruckRepository::class)]
class Truck
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(['fleet:read'])]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['fleet:read'])]
    private string $plateNumber;

    #[ORM\OneToOne(targetEntity: FleetSet::class, mappedBy: "truck", cascade: ['persist'], orphanRemoval: true)]
    private ?FleetSet $fleetSet = null;

    #[ORM\OneToMany(targetEntity: ServiceOrder::class, mappedBy: "truck", cascade: ['persist'], orphanRemoval: true)]
    private Collection $serviceOrders;

    public function __construct()
    {
        $this->serviceOrders = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setPlateNumber(string $plateNumber): self
    {
        $this->plateNumber = $plateNumber;
        return $this;
    }

    public function getPlateNumber(): string
    {
        return $this->plateNumber;
    }

    // Pašalinam @Groups čia, kad nesikartotų FleetSet -> Truck -> FleetSet...
    public function getFleetSet(): ?FleetSet
    {
        return $this->fleetSet;
    }

    public function setFleetSet(?FleetSet $fleetSet): self
    {
        $this->fleetSet = $fleetSet;

        if ($fleetSet && $fleetSet->getTruck() !== $this) {
            $fleetSet->setTruck($this);
        }

        return $this;
    }

    public function getServiceOrders(): Collection
    {
        return $this->serviceOrders;
    }

    public function addServiceOrder(ServiceOrder $serviceOrder): self
    {
        if (!$this->serviceOrders->contains($serviceOrder)) {
            $this->serviceOrders[] = $serviceOrder;
            $serviceOrder->setTruck($this);
        }

        return $this;
    }

    public function removeServiceOrder(ServiceOrder $serviceOrder): self
    {
        if ($this->serviceOrders->removeElement($serviceOrder)) {
            if ($serviceOrder->getTruck() === $this) {
                $serviceOrder->setTruck(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->plateNumber;
    }
}
