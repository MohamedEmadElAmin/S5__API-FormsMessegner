<?php


namespace App\Factory\Log;


use App\Entity\Logs\AuditShippingOrder;
use App\Entity\ShippingOrder\ShippingOrder;
use App\Factory\FactoryBase;
use Doctrine\ORM\EntityManagerInterface;

class AuditShippingOrderFactory implements FactoryBase
{
    public static function create($entity, array $params = []): AuditShippingOrder
    {
        /** @var ShippingOrder $entity */
        $auditShippingOrder = new AuditShippingOrder();
        $auditShippingOrder->setTotal($entity->getTotal());
        $auditShippingOrder->setShippingTrackingNumber($entity->getShippingTrackingNumber());
        $auditShippingOrder->setShippingCompany($entity->getShippingCompany());
        $auditShippingOrder->setDiscount($entity->getDiscount());
        $auditShippingOrder->setOrderId($entity->getOrderId());
        $auditShippingOrder->setShippingDetails($entity->getShippingDetails());
        $auditShippingOrder->setStatusId($entity->getStatus()->getId());
        $auditShippingOrder->setStatusName($entity->getStatus()->getName());
        $auditShippingOrder->setCreatedAt();
        return $auditShippingOrder;
    }
}