<?php

namespace App\Repository;

use App\Entity\IntlTransaction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method IntlTransaction|null find($id, $lockMode = null, $lockVersion = null)
 * @method IntlTransaction|null findOneBy(array $criteria, array $orderBy = null)
 * @method IntlTransaction[]    findAll()
 * @method IntlTransaction[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class IntlTransactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, IntlTransaction::class);
    }

    // /**
    //  * @return IntlTransaction[] Returns an array of IntlTransaction objects
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
    public function findOneBySomeField($value): ?IntlTransaction
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
