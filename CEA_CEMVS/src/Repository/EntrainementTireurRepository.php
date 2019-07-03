<?php

namespace App\Repository;

use App\Entity\EntrainementTireur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EntrainementTireur|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntrainementTireur|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntrainementTireur[]    findAll()
 * @method EntrainementTireur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrainementTireurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EntrainementTireur::class);
    }

    // /**
    //  * @return EntrainementTireur[] Returns an array of EntrainementTireur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EntrainementTireur
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
