<?php

namespace App\Service;

use App\Repository\FleetSetRepository;
use App\Entity\FleetSet;

class FleetSetService
{
    private FleetSetRepository $fleetRepository;

    public function __construct(FleetSetRepository $fleetRepository)
    {
        $this->fleetRepository = $fleetRepository;
    }

    /**
     * @return FleetSet[]
     */
    public function getAll(): array
    {
        return $this->fleetRepository->findAll();
    }

    public function getById(int $id): ?FleetSet
    {
        return $this->fleetRepository->find($id);
    }

    public function getPaginated(int $limit = 10, int $offset = 0): array
    {
        return $this->fleetRepository->findBy([], null, $limit, $offset);
    }

    public function save(FleetSet $fleetSet): void
{
    $this->fleetRepository->add($fleetSet, true);
}

}
