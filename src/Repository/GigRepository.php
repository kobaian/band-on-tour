<?php

namespace App\Repository;

use App\Entity\Gig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gig|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gig|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gig[]    findAll()
 * @method Gig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gig::class);
    }

    // /**
    //  * @return Gig[] Returns an array of Gig objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gig
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
