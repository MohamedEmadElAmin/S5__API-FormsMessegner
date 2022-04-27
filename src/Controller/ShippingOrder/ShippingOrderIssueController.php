<?php

namespace App\Controller\ShippingOrder;

use App\Controller\CustomBaseController;
use App\Entity\ShippingOrder\ShippingOrder;
use App\Entity\ShippingOrder\ShippingOrderIssue;
use App\Serializer\ShippingOrderIssue\ShippingOrderIssueDenormalizer;
use App\Services\Cache\Base\CacheBaseInterface;
use App\Services\ShippingOrderHelper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/rest")
 */
class ShippingOrderIssueController extends CustomBaseController
{
    /**
     * @Route("/shipping-order-issues", name="api.shipping_orders_issues.create" ,methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $result = $this->requestHelper->readJsonDate($request);
        if($result['error']) {
            return $result['response'];
        }

        $result = $this->createObjectFromDeserialization($request, ShippingOrderIssueDenormalizer::class,
            "shippingOrder:create");
        if($result['error']) {
            return $result['response'];
        }

        /** @var ShippingOrderIssue $shippingOrderIssue */
        $shippingOrderIssue =  $result['response'];
        $result = $this->requestHelper->validateEntityObject($shippingOrderIssue);
        if($result['error']) {
            return $result['response'];
        }

        $this->em->persist($shippingOrderIssue);
        $this->em->flush();
        return $this->requestHelper->sendResponse(['message' => "Your Issue placed successfully"]);
    }

}
