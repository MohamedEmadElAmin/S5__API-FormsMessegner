<?php

namespace App\Repository\ShippingOrders;

use App\Entity\ShippingOrder\ShippingOrderIssue;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShippingOrderIssue|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShippingOrderIssue|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShippingOrderIssue[]    findAll()
 * @method ShippingOrderIssue[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShippingOrderIssueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingOrderIssue::class);
    }

    // /**
    //  * @return ShippingOrderIssue[] Returns an array of ShippingOrderIssue objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ShippingOrderIssue
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
