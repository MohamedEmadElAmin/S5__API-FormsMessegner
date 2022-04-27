<?php

namespace App\Repository\ShippingOrders;

use App\Entity\ShippingOrder\ShippingOrderItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShippingOrderItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShippingOrderItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShippingOrderItem[]    findAll()
 * @method ShippingOrderItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShippingOrderItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingOrderItem::class);
    }

    // /**
    //  * @return OrderItem[] Returns an array of OrderItem objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OrderItem
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
