<?php

namespace App\Repository;

use App\Entity\Receptor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Receptor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Receptor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Receptor[]    findAll()
 * @method Receptor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReceptorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Receptor::class);
    }

    // /**
    //  * @return Receptor[] Returns an array of Receptor objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Receptor
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
