<?php

namespace App\Serializer\ShippingOrderIssue;

use App\Entity\ShippingOrder\ShippingOrderIssue;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Doctrine\ORM\EntityManagerInterface;

class ShippingOrderIssueNormalizer implements ContextAwareNormalizerInterface
{
    private UrlGeneratorInterface $router;
    private ObjectNormalizer $normalizer;
    private EntityManagerInterface $entityManager;
    use DenormalizerAwareTrait;

    public function __construct(EntityManagerInterface $entityManager, UrlGeneratorInterface $router, ObjectNormalizer $normalizer)
    {
        $this->router = $router;
        $this->normalizer = $normalizer;
        $this->entityManager = $entityManager;
    }

    public function normalize($shippingOrderIssue, string $format = null, array $context = [])
    {
        //dump("normalize");
        $data = $this->normalizer->normalize($shippingOrderIssue, $format, $context);
        //here you can change anything
        //$data['normalizer']  = true;
        return $data;
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $data instanceof ShippingOrderIssue;
    }
}
