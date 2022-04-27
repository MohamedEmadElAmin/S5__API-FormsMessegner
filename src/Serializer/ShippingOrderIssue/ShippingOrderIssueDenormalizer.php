<?php


namespace App\Serializer\ShippingOrderIssue;
use App\Entity\ShippingOrder\ShippingOrder;
use App\Entity\ShippingOrder\ShippingOrderIssue;
use App\Entity\Utilities\Issue;
use App\Services\Cache\Base\CacheBaseInterface;
use App\Services\RequestHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Exception\CircularReferenceException;
use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ShippingOrderIssueDenormalizer implements DenormalizerInterface
{
    private EntityManagerInterface $entityManager;
    private CacheBaseInterface $issueCache;
    private RequestHelper $requestHelper;

    public function __construct(EntityManagerInterface $entityManager, CacheBaseInterface $issueCache, RequestHelper $requestHelper)
    {
        $this->entityManager = $entityManager;
        $this->issueCache = $issueCache;
        $this->requestHelper = $requestHelper;
    }

    /**
     * @param mixed $data
     * @param string $class
     * @param null $format
     * @param array $context
     */
    public function denormalize($data = [], $class, $format = null, array $context = array())
    {
        //dump("Denormalizer");
        $checkResult = $this->requestHelper->checkExistenceOfParameters($data, ['issue_id', 'Order_id']);
        if($checkResult['error']) {
            throw new \Exception("Parameters are missing.");
        }

        $issue = $this->issueCache->getFromCache($data['issue_id']);
        $shippingOrder = $this->entityManager->getRepository(ShippingOrder::class)->findOneBy(['orderId' => $data['Order_id']]);
        if(!$shippingOrder) {
            throw new \Exception("Order Not Found");
        }

        $shippingOrderIssue = new ShippingOrderIssue();
        $shippingOrderIssue->setIssue($issue);
        $shippingOrderIssue->setDetails($data['details']);
        $shippingOrderIssue->setShippingOrder($shippingOrder);
        return $shippingOrderIssue;
    }

    /**
     * @param mixed $data
     * @param string $type
     * @param null $format
     * @return bool
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        return $type === self::class;
    }
}

//
//    public function supportsDenormalization($data, string $type, string $format = null, array $context = [])
//    {
//        return str_ends_with($type, '[]')
//            && $this->denormalizer->supportsDenormalization($data, substr($type, 0, -2), $format, $context);
//    }
//
//    public function denormalize($data, string $type, string $format = null, array $context = [])
//    {
//        dump("denormalize");
//        if (null === $this->denormalizer) {
//            throw new BadMethodCallException('Please set a denormalizer before calling denormalize()!');
//        }
//        if (!\is_array($data)) {
//            throw new InvalidArgumentException('Data expected to be an array, '.get_debug_type($data).' given.');
//        }
//        if (!str_ends_with($type, '[]')) {
//            throw new InvalidArgumentException('Unsupported class: '.$type);
//        }
//
//        $type = substr($type, 0, -2);
//
//        $builtinType = isset($context['key_type']) ? $context['key_type']->getBuiltinType() : null;
//        foreach ($data as $key => $value) {
//            $subContext = $context;
//            $subContext['deserialization_path'] = ($context['deserialization_path'] ?? false) ? sprintf('%s[%s]', $context['deserialization_path'], $key) : "[$key]";
//
//            if (null !== $builtinType && !('is_'.$builtinType)($key)) {
//                throw NotNormalizableValueException::createForUnexpectedDataType(sprintf('The type of the key "%s" must be "%s" ("%s" given).', $key, $builtinType, get_debug_type($key)), $key, [$builtinType], $subContext['deserialization_path'] ?? null, true);
//            }
//
//            $data[$key] = $this->denormalizer->denormalize($value, $type, $format, $subContext);
//        }
//    }