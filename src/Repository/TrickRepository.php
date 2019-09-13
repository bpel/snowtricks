<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);
    }

    // /**
    //  * @return Trick[] Returns an array of Trick objects
    //  */

    public function findAllTricks()
    {
        return $this->createQueryBuilder('trick')
            ->orderBy('trick.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findAllOneTrick($id)
    {
        return $this->createQueryBuilder('t')
            ->select('t')
            ->leftJoin('t.illustrations','illustrations')
            ->leftJoin('t.videos','videos')
            ->leftJoin('t.messages','messages')
            ->where('t.id = :trick_id')
            ->setParameter('trick_id', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Trick
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
