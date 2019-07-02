<?php

namespace App\Repository;

use App\Entity\ProfilCategorie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProfilCategorie|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfilCategorie|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfilCategorie[]    findAll()
 * @method ProfilCategorie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilCategorieRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProfilCategorie::class);
    }

    // /**
    //  * @return ProfilCategorie[] Returns an array of ProfilCategorie objects
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
    public function findOneBySomeField($value): ?ProfilCategorie
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
