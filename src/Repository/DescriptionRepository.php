<?php

namespace App\Repository;

use App\Entity\Description;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Description>
 *
 * @method Description|null find($id, $lockMode = null, $lockVersion = null)
 * @method Description|null findOneBy(array $criteria, array $orderBy = null)
 * @method Description[]    findAll()
 * @method Description[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DescriptionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Description::class);
    }

    public function add(Description $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Description $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

}
