<?php

namespace App\Repository\Logs;

use App\Entity\Logs\AuditShippingOrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AuditShippingOrderItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuditShippingOrderItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuditShippingOrderItem[]    findAll()
 * @method AuditShippingOrderItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditShippingOrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditShippingOrderItem::class);
    }

    // /**
    //  * @return AuditShippingOrderItem[] Returns an array of AuditShippingOrderItem objects
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
    public function findOneBySomeField($value): ?AuditShippingOrderItem
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
