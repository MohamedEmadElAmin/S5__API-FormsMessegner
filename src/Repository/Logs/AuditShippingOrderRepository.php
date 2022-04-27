<?php

namespace App\Repository\Logs;

use App\Entity\Logs\AuditShippingOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AuditShippingOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuditShippingOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuditShippingOrder[]    findAll()
 * @method AuditShippingOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditShippingOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditShippingOrder::class);
    }

    // /**
    //  * @return AuditShippigOrder[] Returns an array of AuditShippigOrder objects
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
    public function findOneBySomeField($value): ?AuditShippigOrder
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
