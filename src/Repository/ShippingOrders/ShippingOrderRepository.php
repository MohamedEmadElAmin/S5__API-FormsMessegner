<?php

namespace App\Repository\ShippingOrders;

use App\Entity\ShippingOrder\ShippingOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ShippingOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShippingOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShippingOrder[]    findAll()
 * @method ShippingOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ShippingOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ShippingOrder::class);
    }

    public function findEntities($offset , $perPage , $params = []): ?array
    {
        $shippingOrderStatusName = array_key_exists('status' , $params) ? $params['status'] : NULL;

        $qb = $this->createQueryBuilder('u');
        $qb->add('orderBy', 'u.id DESC');
        $qb->setFirstResult( $offset )->setMaxResults( $perPage );
        if($shippingOrderStatusName != NULL)
        {
            $qb->innerJoin('u.status','status');
            $qb->andWhere('status.name = :shippingOrderStatusName')->setParameter("shippingOrderStatusName" , $shippingOrderStatusName);
        }
        $result= [];
        $result['entities'] = $qb->getQuery()->getResult();
        $result['count'] = count($result['entities']);

        $qb->select('count(u)');
        $qb->setFirstResult(NULL)->setMaxResults(NULL);
        $result['totalCount'] = (int)$qb->getQuery()->getSingleScalarResult();
        return $result;
    }

    // /**
    //  * @return Order[] Returns an array of Order objects
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
    public function findOneBySomeField($value): ?Order
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
