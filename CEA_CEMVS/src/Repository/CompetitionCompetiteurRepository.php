<?php

namespace App\Repository;

use App\Entity\CompetitionCompetiteur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method CompetitionCompetiteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method CompetitionCompetiteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method CompetitionCompetiteur[]    findAll()
 * @method CompetitionCompetiteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CompetitionCompetiteurRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, CompetitionCompetiteur::class);
    }

    // /**
    //  * @return CompetitionCompetiteur[] Returns an array of CompetitionCompetiteur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CompetitionCompetiteur
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
