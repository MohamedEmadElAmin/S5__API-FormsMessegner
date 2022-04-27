<?php


namespace App\Services;


use App\Entity\ShippingOrder\ShippingOrder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RequestHelper
{
    protected ObjectManager $em;
    protected ValidatorInterface $validator;


    function __construct(ManagerRegistry $doctrine, ValidatorInterface $validator)
    {
        $this->em = $doctrine->getManager();
        $this->validator = $validator;
    }

    //TODO: use status code as param, instead of fixed values
    public function sendResponse(array $params = [], array $exactParameters = []): JsonResponse
    {
        /*
          2xx: Success
              200 OK
              201 Created
          3xx: Redirect
              301 Moved Permanently
              304 Not Modified
          4xx: Client Error
              400 Bad Request
              401 Unauthorized
              403 Forbidden
              404 Not Found
              410 Gone
           5xx: Server Error
          500 Internal Server Error
        */
        $message = array_key_exists('message' , $params) ? $params['message'] : NULL;
        $data = array_key_exists('data' , $params) ? $params['data'] : NULL;
        $error = array_key_exists('error' , $params) ? $params['error'] : false;

        $code = 200;
        $response = ['success' => true];
        if($error) {
            $response = ['success' => false];
            $code = 404;//Response::HTTP_BAD_REQUEST = 400
        }

        if($message) {
            $response['message'] = $message;
        }
        if($data){
            $response['data'] = $data;
        }

        foreach ($exactParameters as $index => $exactParameter) {
            $response[$index] = $exactParameter;
        }
        return new JsonResponse($response, $code);
    }
    public function readJsonDate(Request $request): array
    {
        $params = [];
        if ($content = $request->getContent()) {
            $params = json_decode($content, true);
        }
        if(!$params) {
            $response = $this->sendResponse(['error' => true, 'message' => "Please Enter valid json."]);
            return ['error' => true , 'response' => $response];
        }

        return ['error' => false , 'response' => $params];
    }
    public function validateEntityObject($entity): array
    {
        $violations = $this->validator->validate($entity);
        if ($violations->count() > 0) {
            $errors =  $this->createErrorsFromValidations($violations);
            $response = $this->sendResponse(['message' => 'Please enter valid data', 'error' => true , 'data' => $errors]);
            return ['error' => true, 'response' => $response];
        }
        //TODO: custom normalize to have more control
        if($entity instanceof ShippingOrder) {
            if(count($entity->getShippingOrderItems()) == 0) {
                $response = $this->sendResponse(['message' => 'Please enter valid data', 'error' => true ,
                    'data' => ['field' => "Order_items", "message" => "This value should not be blank."]]);
                return ['error' => true, 'response' => $response];
            }
        }
        return ['error' => false];
    }

    public function createErrorsFromValidations($violations): ?array
    {
        $violationsList = [];
        foreach ($violations as $violation)
        {
            array_push($violationsList , ['field' => $violation->getPropertyPath(),
                'message' => $violation->getMessage()]);
        }
        return $violationsList;
    }
    public function getRequestQueryParameter(Request $request , $parameter , $params = [])
    {
        $defaultValue = array_key_exists('defaultValue' , $params) ? $params['defaultValue'] : NULL;
        $foundValue = array_key_exists('foundValue' , $params) ? $params['foundValue'] : NULL;

        if($request->query->has($parameter) || $request->query->get($parameter) == 0) {
            return $foundValue == NULL ? $request->query->get($parameter) : $foundValue;
        }
        else {
            return $defaultValue;
        }
    }
    public function checkExistenceOfParameters($data ,array $parameters): array
    {
        foreach ($parameters as $parameter)
        {
            if(!isset($data[$parameter]) || $data[$parameter] == "") {
                $response = $this->sendResponse(["error" => true, "message" => "Parameters are missing."]);
                return ['error' => true, "message" => $response];
            }
        }
        return ["error" => false];
    }
}