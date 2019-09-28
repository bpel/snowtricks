<?php

namespace App\Repository;

use App\Entity\TokenPasswordLost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method TokenPasswordLost|null find($id, $lockMode = null, $lockVersion = null)
 * @method TokenPasswordLost|null findOneBy(array $criteria, array $orderBy = null)
 * @method TokenPasswordLost[]    findAll()
 * @method TokenPasswordLost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TokenPasswordLostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TokenPasswordLost::class);
    }

    public function findTokenByUser($user)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user = :user')
            ->setParameter('user', $user)
            ->andWhere('t.used = false')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findToken($token)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.token = :token')
            ->setParameter('token', $token)
            ->join('t.user','u')
            ->addSelect('u')
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
