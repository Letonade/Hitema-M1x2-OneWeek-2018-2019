<?php

namespace App\Repository;

use App\Entity\EntrainementType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method EntrainementType|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntrainementType|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntrainementType[]    findAll()
 * @method EntrainementType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrainementTypeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, EntrainementType::class);
    }

    // /**
    //  * @return EntrainementType[] Returns an array of EntrainementType objects
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
    public function findOneBySomeField($value): ?EntrainementType
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
