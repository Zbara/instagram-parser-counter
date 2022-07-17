<?php

namespace App\Repository;

use App\Entity\Instagram;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Instagram>
 *
 * @method Instagram|null find($id, $lockMode = null, $lockVersion = null)
 * @method Instagram|null findOneBy(array $criteria, array $orderBy = null)
 * @method Instagram[]    findAll()
 * @method Instagram[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstagramRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Instagram::class);
    }

    public function getItems()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
