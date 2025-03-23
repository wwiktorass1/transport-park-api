<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity]
class Trailer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(['fleet:read'])]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['fleet:read'])]
    private string $registrationNumber;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['fleet:read'])]
    private string $type;

    #[ORM\OneToOne(targetEntity: FleetSet::class, mappedBy: "trailer")]
    private ?FleetSet $fleetSet = null;

    #[ORM\OneToMany(targetEntity: ServiceOrder::class, mappedBy: "trailer")]
    private Collection $serviceOrders;

    public function __construct()
    {
        $this->serviceOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;
        return $this;
    }

    /**
     * Alias for setRegistrationNumber, used for compatibility with tests
     */
    public function setPlateNumber(string $plateNumber): self
    {
        return $this->setRegistrationNumber($plateNumber);
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;
        return $this;
    }

    public function getFleetSet(): ?FleetSet
    {
        return $this->fleetSet;
    }

    public function setFleetSet(?FleetSet $fleetSet): self
    {
        $this->fleetSet = $fleetSet;
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
            $serviceOrder->setTrailer($this);
        }
        return $this;
    }

    public function removeServiceOrder(ServiceOrder $serviceOrder): self
    {
        if ($this->serviceOrders->contains($serviceOrder)) {
            $this->serviceOrders->removeElement($serviceOrder);
            if ($serviceOrder->getTrailer() === $this) {
                $serviceOrder->setTrailer(null);
            }
        }
        return $this;
    }
}
