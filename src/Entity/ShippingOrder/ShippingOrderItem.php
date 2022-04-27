<?php

namespace App\Entity\ShippingOrder;

use App\Repository\ShippingOrders\ShippingOrderItemRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ORM\Entity(repositoryClass=ShippingOrderItemRepository::class)
 * @ORM\Table(name="orders__shipping_orders_items")
 */
class ShippingOrderItem
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", options={"default" : 1})
     * @Assert\NotBlank()
     * @Assert\Type(type="integer")
     */
    private $quantity = 1;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     * @Groups({"shippingOrder:create"})
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=ShippingOrder::class, inversedBy="shippingOrderItems")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $shippingOrder;

    /**
     * @ORM\ManyToOne(targetEntity=ShippingBox::class)
     */
    private $shippingBox;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }
    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getShippingOrder(): ?ShippingOrder
    {
        return $this->shippingOrder;
    }
    public function setShippingOrder(?ShippingOrder $shippingOrder): self
    {
        $this->shippingOrder = $shippingOrder;

        return $this;
    }

    public function getShippingBox(): ?ShippingBox
    {
        return $this->shippingBox;
    }
    public function setShippingBox(?ShippingBox $shippingBox): self
    {
        $this->shippingBox = $shippingBox;

        return $this;
    }
}
