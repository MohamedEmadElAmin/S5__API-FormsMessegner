<?php


namespace App\Serializer\ShippingOrderIssue;
use App\Entity\ShippingOrder\ShippingOrderIssue;
use App\Entity\Utilities\Issue;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonDecode;
use Symfony\Component\Serializer\Encoder\JsonEncode;


class ShippingOrderIssueEncoder implements EncoderInterface, DecoderInterface
{
    public const FORMAT = 'json';

    protected JsonEncode $encodingImpl;
    protected JsonDecode $decodingImpl;

    public function __construct(JsonEncode $encodingImpl = null, JsonDecode $decodingImpl = null)
    {
        $this->encodingImpl = $encodingImpl ?? new JsonEncode();
        $this->decodingImpl = $decodingImpl ?? new JsonDecode([JsonDecode::ASSOCIATIVE => true]);
    }

    /**
     * {@inheritdoc}
     */
    public function encode($data, string $format, array $context = [])
    {
        //$data is array, you can changed it here, before (encode)
        //dump('encoder');
        //$data['encoder'] = true;
        $result = $this->encodingImpl->encode($data, self::FORMAT, $context);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function decode(string $data, string $format, array $context = [])
    {
        //you can't change data here, must implement denormalizer
        //dump('decoder');
        //dump($data);
        $result =  $this->decodingImpl->decode($data, self::FORMAT, $context);
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsEncoding(string $format)
    {
        return self::FORMAT === $format;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDecoding(string $format)
    {
        return self::FORMAT === $format;
    }
}

