<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class ServiceOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private int $id;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['fleet:read'])]
    private string $description;

    #[ORM\Column(type: "datetime")]
    #[Groups(['fleet:read'])]
    private \DateTimeInterface $startDate;

    #[ORM\Column(type: "datetime", nullable: true)]
    #[Groups(['fleet:read'])]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(type: "string", length: 50)]
    #[Groups(['fleet:read'])]
    private string $status;

    #[ORM\ManyToOne(targetEntity: FleetSet::class, inversedBy: "serviceOrders")]
    #[ORM\JoinColumn(nullable: true)]
    private ?FleetSet $fleetSet = null;

    #[ORM\ManyToOne(targetEntity: Truck::class, inversedBy: "serviceOrders")]
    #[ORM\JoinColumn(nullable: true)]
    private ?Truck $truck = null;

    #[ORM\ManyToOne(targetEntity: Trailer::class, inversedBy: "serviceOrders")]
    #[ORM\JoinColumn(nullable: true)]
    private ?Trailer $trailer = null;

    #[ORM\Column(type: "datetime_immutable")]
    #[Groups(['fleet:read'])]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(type: "datetime_immutable", nullable: true)]
    #[Groups(['fleet:read'])]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\Column(type: "string", length: 255)]
    #[Groups(['fleet:read'])]
    private string $orderNumber;

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;
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

    public function getTruck(): ?Truck
    {
        return $this->truck;
    }

    public function setTruck(?Truck $truck): self
    {
        $this->truck = $truck;
        return $this;
    }

    public function getTrailer(): ?Trailer
    {
        return $this->trailer;
    }

    public function setTrailer(?Trailer $trailer): self
    {
        $this->trailer = $trailer;
        return $this;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(string $orderNumber): self
    {
        $this->orderNumber = $orderNumber;
        return $this;
    }

        public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
    
}
