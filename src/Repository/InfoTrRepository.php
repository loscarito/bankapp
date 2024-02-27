<?php

namespace App\Repository;

use App\Entity\InfoTr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method InfoTr|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoTr|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoTr[]    findAll()
 * @method InfoTr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoTrRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoTr::class);
    }

    // /**
    //  * @return InfoTr[] Returns an array of InfoTr objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InfoTr
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
