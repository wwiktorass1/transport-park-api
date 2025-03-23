<?php

namespace App\Entity;

use App\Repository\FleetSetRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FleetSetRepository::class)]
class FleetSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(['fleet:read'])]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    #[Groups(['fleet:read'])]
    private string $name;

    #[ORM\OneToOne(targetEntity: Truck::class, inversedBy: "fleetSet", cascade: ['persist'], orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['fleet:read'])]
    private Truck $truck;

    #[ORM\OneToOne(targetEntity: Trailer::class, inversedBy: "fleetSet", cascade: ['persist'], orphanRemoval: true)]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['fleet:read'])]
    private ?Trailer $trailer = null;

    #[ORM\ManyToMany(targetEntity: Driver::class, inversedBy: "fleetSets", cascade: ['persist'])]
    #[ORM\JoinTable(name: "fleet_set_driver")]
    #[Groups(['fleet:read'])]
    private Collection $drivers;

    #[ORM\OneToMany(mappedBy: "fleetSet", targetEntity: ServiceOrder::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $serviceOrders;

    public function __construct()
    {
        $this->drivers = new ArrayCollection();
        $this->serviceOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getTruck(): ?Truck
    {
        return $this->truck;
    }

    public function setTruck(Truck $truck): self
    {
        $this->truck = $truck;

        if ($truck->getFleetSet() !== $this) {
            $truck->setFleetSet($this);
        }

        return $this;
    }

    public function getTrailer(): ?Trailer
    {
        return $this->trailer;
    }

    public function setTrailer(?Trailer $trailer): self
    {
        $this->trailer = $trailer;

        if ($trailer && $trailer->getFleetSet() !== $this) {
            $trailer->setFleetSet($this);
        }

        return $this;
    }

    public function getDrivers(): Collection
    {
        return $this->drivers;
    }

    public function addDriver(Driver $driver): self
    {
        if (!$this->drivers->contains($driver)) {
            $this->drivers[] = $driver;
        }

        return $this;
    }

    public function removeDriver(Driver $driver): self
    {
        $this->drivers->removeElement($driver);
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
            $serviceOrder->setFleetSet($this);
        }

        return $this;
    }

    public function removeServiceOrder(ServiceOrder $serviceOrder): self
    {
        if ($this->serviceOrders->removeElement($serviceOrder)) {
            if ($serviceOrder->getFleetSet() === $this) {
                $serviceOrder->setFleetSet(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return 'Fleet #' . $this->id;
    }
}
