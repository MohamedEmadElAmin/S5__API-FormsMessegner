<?php

namespace App\Controller\ShippingOrder;

use App\Controller\CustomBaseController;
use App\Entity\ShippingOrder\ShippingBox;
use App\Entity\ShippingOrder\ShippingOrder;
use App\Services\Cache\Base\CacheBaseInterface;
use App\Services\Cache\IssueCache;
use App\Services\RequestHelper;
use App\Services\ShippingOrderHelper;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/rest")
 */
class ShippingOrderController extends CustomBaseController
{
    private CacheBaseInterface $shippingOrderStatusCache;

    function __construct(ManagerRegistry $doctrine, ValidatorInterface $validator, SerializerInterface $serializer,
                         ShippingOrderHelper $shippingOrderHelper, CacheBaseInterface $shippingOrderStatusCache,
                         RequestHelper $requestHelper)
    {
        parent::__construct($doctrine, $validator, $serializer, $requestHelper, $shippingOrderHelper);
        $this->shippingOrderStatusCache = $shippingOrderStatusCache;
    }


    /**
     * @Route("/shipping-orders", name="api.shipping_orders.get", methods={"GET"})
     */
    public function index(Request $request): Response
    {
        $statusName = $this->requestHelper->getRequestQueryParameter($request, 'status');
        $this->evaluatePagination($request);

        $entities = $this->em->getRepository(ShippingOrder::class)->findEntities($this->offset, $this->perPage ,
            ['status' => $statusName]);
        //$product = $this->em->getRepository(ShippingOrder::class)->findOneBy(["id" => 1]);
        $json = $this->serializer->serialize($entities['entities'],'json',
            ['groups' => ['shippingOrder:get']]);

        return $this->requestHelper->sendResponse(['data' => json_decode($json)] ,
            ['totalCount' => $entities['totalCount'] , 'count' => $entities['count']]);
        //return $this->json($entities['entities'], 200, [], ['groups' => ['shippingOrder:get']]);
    }

    /**
     * @Route("/shipping-orders", name="api.shipping_orders.create", methods={"POST"})
     */
    public function create(Request $request): Response
    {
        $result = $this->requestHelper->readJsonDate($request);
        if($result['error']) {
            return $result['response'];
        }

        $result = $this->createObjectFromDeserialization($request, ShippingOrder::class, "shippingOrder:create");
        if($result['error']) {
            return $result['response'];
        }

        /** @var ShippingOrder $shippingOrder */
        $shippingOrder =  $result['response'];
        $status = $this->shippingOrderStatusCache->getFromCache('ORDER_RECEIVED');
        $shippingOrder->setStatus($status);
        $result = $this->requestHelper->validateEntityObject($shippingOrder);
        if($result['error']) {
            return $result['response'];
        }

        $this->em->persist($shippingOrder);
        $this->em->flush();
        return $this->requestHelper->sendResponse(['message' => "Your order placed successfully"]);
    }

    /**
     * @Route("/shipping-orders/{id}/cancel", name="api.shipping_orders.cancel" ,methods={"PATCH"})
     */
    public function cancel(Request $request, $id): Response
    {
        $result = $this->checkOrderIdAndStatusInRequest($id, 'ORDER_CANCELED');
        if($result['error']) {
            return $result['response'];
        }

        $shippingOrder = $result['response'];
        $status = $this->shippingOrderStatusCache->getFromCache('ORDER_CANCELED');
        $shippingOrder->setStatus($status);
        $this->em->flush();

        return $this->requestHelper->sendResponse(['message' => "Your order is canceled"]);
    }

    /**
     * @Route("/shipping-orders/{id}/complete-picking", name="api.shipping_orders.completePicking" ,methods={"PATCH"})
     */
    public function completePicking(Request $request, $id): Response
    {
        $result = $this->checkOrderIdAndStatusInRequest($id , 'ORDER_READY_TO_SHIP');
        if($result['error']) {
            return $result['response'];
        }

        $shippingOrder = $result['response'];
        $status = $this->shippingOrderStatusCache->getFromCache('ORDER_READY_TO_SHIP');
        $shippingOrder->setStatus($status);
        $box = new ShippingBox();
        $box->setName('Box-'.$shippingOrder->getOrderId());
        $this->em->persist($box);
        $this->em->flush();
        return $this->requestHelper->sendResponse(['message' => "Your order is ready to be shipped" , "data" => ['Order_id' => $shippingOrder->getOrderId(),
            'Box_id' => $box->getId() ]]);
    }

    /**
     * @Route("/shipping-orders/{id}/ship", name="api.shipping_orders.ship" ,methods={"PATCH"})
     */
    public function ship(Request $request, $id): Response
    {
        $result = $this->checkOrderIdAndStatusInRequest($id , 'ORDER_SHIPPED');
        if($result['error']) {
            return $result['response'];
        }
        /** @var ShippingOrder $shippingOrder */
        $shippingOrder = $result['response'];


        $payLoadCheckResult = $this->requestHelper->readJsonDate($request);
        if($payLoadCheckResult['error']) {
            return $payLoadCheckResult['response'];
        }
        $params = $payLoadCheckResult['response'];

        $result = $this->requestHelper->checkExistenceOfParameters($params, ['Shipping_tracking_number', 'Shipping_company']);
        if($result['error']){
            return $result['response'];
        }


        $status = $this->shippingOrderStatusCache->getFromCache('ORDER_SHIPPED');
        $shippingOrder->setStatus($status);
        $shippingOrder->setShippingCompany($params['Shipping_company']);
        $shippingOrder->setShippingTrackingNumber($params['Shipping_tracking_number']);
        $result = $this->requestHelper->validateEntityObject($shippingOrder);
        if($result['error']) {
            return $result['response'];
        }

        $this->em->flush();
        return $this->requestHelper->sendResponse(['message' => "Your order is shipped"]);
    }
}
