<?php

namespace App\Entity\Logs;

use App\Repository\Logs\AuditShippingOrderRepository;
use App\Traits\Action;
use App\Traits\TimeStamp;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AuditShippingOrderRepository::class)
 * @ORM\Table(name="audit__shipping_orders")
 */
class AuditShippingOrder
{
    use TimeStamp;
    use Action;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"Audit"})
     */
    private $orderId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"Audit"})
     */
    private $statusId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Audit"})
     */
    private $statusName;

    /**
     * @ORM\Column(type="float", precision=10, scale=2, nullable=true)
     * @Groups({"Audit"})
     */
    private $total;

    /**
     * @ORM\Column(type="float", precision=10, scale=2, nullable=true)
     * @Groups({"Audit"})
     */
    private $discount;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Audit"})
     */
    private $shippingTrackingNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Audit"})
     */
    private $shippingCompany;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"Audit"})
     */
    private $shippingDetails;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderId(): ?int
    {
        return $this->orderId;
    }
    public function setOrderId(?int $orderId): self
    {
        $this->orderId = $orderId;

        return $this;
    }

    public function getStatusId(): ?int
    {
        return $this->statusId;
    }
    public function setStatusId(?int $statusId): self
    {
        $this->statusId = $statusId;

        return $this;
    }

    public function getStatusName(): ?string
    {
        return $this->statusName;
    }
    public function setStatusName(?string $statusName): self
    {
        $this->statusName = $statusName;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }
    public function setTotal(?float $total): self
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
}
