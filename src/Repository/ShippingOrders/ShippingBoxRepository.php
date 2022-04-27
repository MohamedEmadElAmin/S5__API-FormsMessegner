<?php

namespace App\Repository\ShippingOrders;

use App\Entity\ShippingOrder\ShippingBox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShippingBox|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShippingBox|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShippingBox[]    findAll()
 * @method ShippingBox[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShippingBoxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingBox::class);
    }

    // /**
    //  * @return ShippingBox[] Returns an array of ShippingBox objects
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
    public function findOneBySomeField($value): ?ShippingBox
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
