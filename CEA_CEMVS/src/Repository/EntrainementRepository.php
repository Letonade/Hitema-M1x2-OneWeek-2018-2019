<?php

namespace App\Repository;

use App\Entity\Entrainement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Entrainement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrainement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrainement[]    findAll()
 * @method Entrainement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrainementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Entrainement::class);
    }

    public function getMyEntrainementByDate(\DateTime $date_debut, \DateTime $date_fin){
        return $this->createQueryBuilder('ENT')
            ->andWhere('ENT.DateDebut > :date_debut')
            ->andWhere('ENT.DateFin < :date_fin')
            ->setParameter('date_debut', $date_debut)
            ->setParameter('date_fin', $date_fin)
            ->getQuery()
            ->getResult()
        ;
    }

    // /**
    //  * @return Entrainement[] Returns an array of Entrainement objects
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
    public function findOneBySomeField($value): ?Entrainement
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
