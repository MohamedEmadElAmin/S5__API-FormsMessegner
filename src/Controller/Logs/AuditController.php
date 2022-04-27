<?php

namespace App\Controller\Logs;

use App\Controller\CustomBaseController;
use App\Entity\Logs\AuditShippingOrder;
use App\Entity\Logs\AuditShippingOrderIssue;
use App\Entity\Logs\AuditShippingOrderItem;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api/rest")
 */
class AuditController extends CustomBaseController
{
    /**
     * @Route("/log/shipping-orders/{id}", name="logs_audit")
     */
    public function index(Request $request, $id): Response
    {
        $result = $this->checkOrderIdAndStatusInRequest($id);
        if($result['error']) {
            return $result['response'];
        }

        $auditShippingOrder = $this->em->getRepository(AuditShippingOrder::class)->findBy(['orderId' => $id]);
        $auditShippingOrderIssues = $this->em->getRepository(AuditShippingOrderIssue::class)->findBy(['orderId' => $id]);
        $auditShippingOrderItems = $this->em->getRepository(AuditShippingOrderItem::class)->findBy(['orderId' => $id]);

        $json1 = $this->serializer->serialize($auditShippingOrder,'json',
            ['groups' => ['Audit']]);
        $json2 = $this->serializer->serialize($auditShippingOrderIssues,'json',
            ['groups' => ['Audit']]);
        $json3 = $this->serializer->serialize($auditShippingOrderItems,'json',
            ['groups' => ['Audit']]);

        return $this->requestHelper->sendResponse(['data' => ["shippingOrderLog" => json_decode($json1),
            "shippingOrderIssuesLog"=> json_decode($json2) , "shippingOrderItemsLog" => json_decode($json3)]]);
    }
}
