<?php

namespace App\Repository;

use App\Entity\Gig;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gig|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gig|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gig[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GigRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gig::class);
    }

    public function findAll(): array
    {
        return $this->findBy([], ['date' => 'ASC']);
    }
}
