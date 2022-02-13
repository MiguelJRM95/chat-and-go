<?php

namespace App\Repository;

use App\Entity\Peticion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Peticion|null find($id, $lockMode = null, $lockVersion = null)
 * @method Peticion|null findOneBy(array $criteria, array $orderBy = null)
 * @method Peticion[]    findAll()
 * @method Peticion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PeticionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Peticion::class);
    }

    // /**
    //  * @return Peticion[] Returns an array of Peticion objects
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
    public function findOneBySomeField($value): ?Peticion
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
