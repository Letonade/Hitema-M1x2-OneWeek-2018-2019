<?php

namespace App\Repository;

use App\Entity\TireurGroupe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method TireurGroupe|null find($id, $lockMode = null, $lockVersion = null)
 * @method TireurGroupe|null findOneBy(array $criteria, array $orderBy = null)
 * @method TireurGroupe[]    findAll()
 * @method TireurGroupe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TireurGroupeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, TireurGroupe::class);
    }

    // /**
    //  * @return TireurGroupe[] Returns an array of TireurGroupe objects
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
    public function findOneBySomeField($value): ?TireurGroupe
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
