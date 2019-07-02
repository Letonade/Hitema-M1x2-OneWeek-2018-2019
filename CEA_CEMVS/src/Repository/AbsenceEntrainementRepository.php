<?php

namespace App\Repository;

use App\Entity\AbsenceEntrainement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AbsenceEntrainement|null find($id, $lockMode = null, $lockVersion = null)
 * @method AbsenceEntrainement|null findOneBy(array $criteria, array $orderBy = null)
 * @method AbsenceEntrainement[]    findAll()
 * @method AbsenceEntrainement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbsenceEntrainementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AbsenceEntrainement::class);
    }

    // /**
    //  * @return AbsenceEntrainement[] Returns an array of AbsenceEntrainement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AbsenceEntrainement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
