<?php

namespace App\Entity\ShippingOrder;

use App\Repository\ShippingOrders\ShippingOrderRepository;
use App\Traits\TimeStamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ShippingOrderRepository::class)
 * @ORM\Table(name="orders__shipping_orders" ,
 * indexes=
 *     {
 *         @ORM\Index(name="order_id_index" , columns={"order_id"})
 *     }
 * )
 * @UniqueEntity(fields="orderId", message="This order is already exsisted.")
 * @ORM\HasLifecycleCallbacks()
 */
class ShippingOrder
{
    use TimeStamp;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", unique=true)
     * @Assert\NotBlank()
     * @Assert\Positive
     * @Assert\Type(type="integer")
     * @SerializedName("Order_id")
     * @Groups({"shippingOrder:get", "shippingOrder:create"})
     */
    private $orderId;

    /**
     * @ORM\Column(type="float")
     * @Assert\GreaterThan(0)
     * @Assert\Positive
     * @Assert\NotBlank()
     * @Assert\Type(type="float", message="invalid")
     * @SerializedName("Order_total")
     * @Groups({"shippingOrder:get", "shippingOrder:create"})
     */
    private $total;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank()
     * @Assert\Positive
     * @Assert\LessThan(propertyPath="total")
     * @Assert\Type(type="float", message="invalid")
     * @SerializedName("Order_discount")
     * @Groups({"shippingOrder:get", "shippingOrder:create"})
     */
    private $discount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length
     * (
     *      min = 2,
     *      max = 254,
     *      minMessage = "shippingTrackingNumber must be at least {{ limit }} characters long",
     *      maxMessage = "shippingTrackingNumber cannot be longer than {{ limit }} characters long"
     * )
     */
    private $shippingTrackingNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Type("string")
     * @Assert\Length
     * (
     *      min = 2,
     *      max = 254,
     *      minMessage = "shippingTrackingNumber must be at least {{ limit }} characters long",
     *      maxMessage = "shippingTrackingNumber cannot be longer than {{ limit }} characters long"
     * )
     */
    private $shippingCompany;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     * @Assert\Type(type="string")
     * @SerializedName("Shipping_details")
     * @Groups({"shippingOrder:get", "shippingOrder:create"})
     */
    private $shippingDetails;

    /**
     * @ORM\ManyToOne(targetEntity=OrderStatus::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"shippingOrder:get", "shippingOrder:create"})
     * @Assert\NotBlank()
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=ShippingOrderItem::class, mappedBy="shippingOrder", cascade={"persist"})
     * @SerializedName("Order_items")
     * @Groups({"shippingOrder:create"})
     * @Assert\NotBlank()
     */
    private $shippingOrderItems;



    public function __construct()
    {
        $this->shippingOrderItems = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }
    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getDiscount(): ?float
    {
        return $this->discount;
    }
    public function setDiscount(?float $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    public function getShippingTrackingNumber(): ?string
    {
        return $this->shippingTrackingNumber;
    }
    public function setShippingTrackingNumber(?string $shippingTrackingNumber): self
    {
        $this->shippingTrackingNumber = $shippingTrackingNumber;

        return $this;
    }

    public function getShippingCompany(): ?string
    {
        return $this->shippingCompany;
    }
    public function setShippingCompany(?string $shippingCompany): self
    {
        $this->shippingCompany = $shippingCompany;

        return $this;
    }

    public function getShippingDetails(): ?string
    {
        return $this->shippingDetails;
    }
    public function setShippingDetails(?string $shippingDetails): self
    {
        $this->shippingDetails = $shippingDetails;

        return $this;
    }

    public function getStatus(): ?OrderStatus
    {
        return $this->status;
    }
    public function setStatus(?OrderStatus $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection|ShippingOrderItem[]
     */
    public function getShippingOrderItems(): Collection
    {
        return $this->shippingOrderItems;
    }
    public function addShippingOrderItem(ShippingOrderItem $shippingOrderItem): self
    {
        if (!$this->shippingOrderItems->contains($shippingOrderItem)) {
            $this->shippingOrderItems[] = $shippingOrderItem;
            $shippingOrderItem->setShippingOrder($this);
        }

        return $this;
    }
    public function removeShippingOrderItem(ShippingOrderItem $shippingOrderItem): self
    {
        if ($this->shippingOrderItems->removeElement($shippingOrderItem)) {
            // set the owning side to null (unless already changed)
            if ($shippingOrderItem->getShippingOrder() === $this) {
                $shippingOrderItem->setShippingOrder(null);
            }
        }

        return $this;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }
    public function setOrderId(int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }
}
