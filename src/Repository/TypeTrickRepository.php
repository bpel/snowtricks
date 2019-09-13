<?php

namespace App\Repository;

use App\Entity\TypeTrick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TypeTrick|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeTrick|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeTrick[]    findAll()
 * @method TypeTrick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeTrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeTrick::class);
    }

    // /**
    //  * @return TypeTrick[] Returns an array of TypeTrick objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TypeTrick
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
