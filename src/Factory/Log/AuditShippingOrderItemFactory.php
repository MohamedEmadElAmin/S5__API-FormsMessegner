<?php


namespace App\Factory\Log;


use App\Entity\Logs\AuditShippingOrderItem;
use App\Entity\ShippingOrder\ShippingOrderItem;
use App\Factory\FactoryBase;
use Doctrine\ORM\EntityManagerInterface;

class AuditShippingOrderItemFactory implements FactoryBase
{

    public static function create($entity, array $params = [])
    {
        /** @var ShippingOrderItem $entity */
        $auditShippingOrderItem = new AuditShippingOrderItem();

        if($entity->getShippingBox()) {
            $auditShippingOrderItem->setBoxId($entity->getShippingBox()->getId());
            $auditShippingOrderItem->setBoxName($entity->getShippingBox()->getName());
        }

        $auditShippingOrderItem->setProductId($entity->getProduct()->getId());
        $auditShippingOrderItem->setProductName($entity->getProduct()->getName());
        $auditShippingOrderItem->setCreatedAt();
        $auditShippingOrderItem->setOrderId($entity->getShippingOrder()->getOrderId());
        return $auditShippingOrderItem;
    }
}