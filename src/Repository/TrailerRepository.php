<?php

namespace App\Repository;

use App\Entity\Trailer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trailer>
 *
 * @method Trailer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trailer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trailer[]    findAll()
 * @method Trailer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrailerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trailer::class);
    }

    public function add(Trailer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trailer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


}
