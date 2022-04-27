<?php


namespace App\Factory\Log;


use App\Entity\Logs\AuditShippingOrderIssue;
use App\Entity\ShippingOrder\ShippingOrderIssue;
use App\Factory\FactoryBase;
use Doctrine\ORM\EntityManagerInterface;

class AuditShippingOrderIssueFactory implements FactoryBase
{

    public static function create($entity, array $params = [])
    {
        /** @var ShippingOrderIssue $entity */
        $auditShippingOrderIssue = new AuditShippingOrderIssue();
        $auditShippingOrderIssue->setOrderId($entity->getShippingOrder()->getId());

        if($entity->getIssue()) {
            $auditShippingOrderIssue->setIssueId($entity->getId());
            $auditShippingOrderIssue->setIssueName($entity->getIssue()->getName());
            $auditShippingOrderIssue->setIssueDetails($entity->getDetails());
        }

        $auditShippingOrderIssue->setCreatedAt();
        return $auditShippingOrderIssue;
    }
}