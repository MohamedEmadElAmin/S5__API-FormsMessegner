<?php

namespace App\Repository\Logs;

use App\Entity\Logs\AuditShippingOrderIssue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AuditShippingOrderIssue|null find($id, $lockMode = null, $lockVersion = null)
 * @method AuditShippingOrderIssue|null findOneBy(array $criteria, array $orderBy = null)
 * @method AuditShippingOrderIssue[]    findAll()
 * @method AuditShippingOrderIssue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AuditShippingOrderIssueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AuditShippingOrderIssue::class);
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
