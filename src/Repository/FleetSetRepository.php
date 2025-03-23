<?php

namespace App\Repository;

use App\Entity\FleetSet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<FleetSet>
 *
 * @method FleetSet|null find($id, $lockMode = null, $lockVersion = null)
 * @method FleetSet|null findOneBy(array $criteria, array $orderBy = null)
 * @method FleetSet[]    findAll()
 * @method FleetSet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FleetSetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FleetSet::class);
    }

    public function add(FleetSet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(FleetSet $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
