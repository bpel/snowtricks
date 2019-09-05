<?php

namespace App\Repository;

use App\Entity\PlatformVideo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method PlatformVideo|null find($id, $lockMode = null, $lockVersion = null)
 * @method PlatformVideo|null findOneBy(array $criteria, array $orderBy = null)
 * @method PlatformVideo[]    findAll()
 * @method PlatformVideo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlatformVideoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PlatformVideo::class);
    }

    // /**
    //  * @return PlatformVideo[] Returns an array of PlatformVideo objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PlatformVideo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
