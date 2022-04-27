<?php


namespace App\Services;


use App\Entity\ShippingOrder\ShippingOrder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;


class ShippingOrderHelper
{
    private ObjectManager $em;
    private array $allowedStatusToBeCancelled = ["ORDER_RECEIVED", "ORDER_PROCESSING" ,"ORDER_READY_TO_SHIP"];
    private array $allowedStatusToBeComplete = ["ORDER_RECEIVED", "ORDER_PROCESSING"];
    private array $allowedStatusToBeShipped = ["ORDER_READY_TO_SHIP", "ORDER_PROCESSING"];

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    public function checkShippingOrderStatus(ShippingOrder $shippingOrder, string $targetStatus): array
    {
        $checkArray = [];
        if($targetStatus == "ORDER_CANCELED"){
            $checkArray = $this->allowedStatusToBeCancelled;
        }else if($targetStatus == "ORDER_READY_TO_SHIP"){
            $checkArray = $this->allowedStatusToBeComplete;
        }else if($targetStatus == "ORDER_SHIPPED"){
            $checkArray = $this->allowedStatusToBeShipped;
        }

        $currentStatus = $shippingOrder->getStatus();
        if (in_array($currentStatus, $checkArray)) {
            return ['error' => false];
        }
        $list = implode(',' , $checkArray);
        return ['error' => true, 'message'=>
            "Shipping Order status (${currentStatus}), your action can only be valid if shipping status any one of the following list (${list})",
            'currentStatus' => $currentStatus->getName()];
    }
}