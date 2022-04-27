<?php


namespace App\Controller;

use App\Entity\ShippingOrder\ShippingOrder;
use App\Services\RequestHelper;
use App\Services\ShippingOrderHelper;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CustomBaseController extends AbstractController
{
    protected ObjectManager $em;
    protected ValidatorInterface $validator;
    protected SerializerInterface $serializer;
    protected int $perPage = 5;
    protected int $currentPage = 1;
    protected int $offset = 1;
    protected RequestHelper $requestHelper;
    protected ShippingOrderHelper $shippingOrderHelper;

    function __construct(ManagerRegistry $doctrine, ValidatorInterface $validator, SerializerInterface $serializer,
                         RequestHelper $requestHelper, ShippingOrderHelper $shippingOrderHelper)
    {
        $this->em = $doctrine->getManager();
        $this->validator = $validator;
        $this->serializer = $serializer;
        $this->requestHelper = $requestHelper;
        $this->shippingOrderHelper = $shippingOrderHelper;
    }

    protected function createObjectFromDeserialization($request, $entityClass , $group): array
    {
        $entity = null;
        try {
            $entity = $this->serializer->deserialize(
                $request->getContent(),
                $entityClass, 'json', ["groups" => $group]
            );
        } catch (\Exception $e) {
            $response = $this->requestHelper->sendResponse(['error' => true, 'message' => $e->getMessage()]);
            return ['error' => true , 'response' => $response];
        }
        return ['error' => false, 'response' => $entity];
    }
    protected function evaluatePagination(Request $request)
    {
        if($request->getRealMethod() == "POST") {
            $params = $request->request->all();
        }
        else {
            $params = $request->query->all();
        }
        $this->currentPage = array_key_exists('page' , $params) && is_numeric($params['page']) ? (int)$params['page'] : 1;
        $this->perPage = array_key_exists('per_page' , $params) && is_numeric($params['per_page']) ? (int)$params['per_page'] : $this->perPage;
        $this->offset = ($this->currentPage - 1) * $this->perPage;
    }


    //TODO: using of custom paramConverter instead of ($id)
    protected function checkOrderIdAndStatusInRequest($id, ?string $targetStatus = NULL): ?array
    {
        if(!isset($id) || !is_numeric($id)) {
            return ['error' => true , 'response' => $this->requestHelper->sendResponse(['error' => true, 'message' => 'please enter valid id.'])];
        }

        /** @var ShippingOrder $shippingOrder */
        $shippingOrder = $this->em->getRepository(ShippingOrder::class)->findOneBy(['orderId' => $id]);
        if(!$shippingOrder) {
            return ['error' => true , 'response' => $this->requestHelper->sendResponse(['error' => true, 'message' => 'Shipping Order not found.'])];
        }

        if($targetStatus != NULL) {
            $result = $this->shippingOrderHelper->checkShippingOrderStatus($shippingOrder, $targetStatus);
            if($result['error']) {
                return ['error' => true , 'response' => $this->requestHelper->sendResponse(
                    ['error' => true, 'message' => $result['message'] , 'data' => ['currentStatus' => $result['currentStatus']]])];
            }
        }

        return ['error' => false , 'response' => $shippingOrder];
    }
}