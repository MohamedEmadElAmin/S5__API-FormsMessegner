<?php

namespace App\Entity\Logs;

use App\Repository\Logs\AuditShippingOrderItemRepository;
use App\Traits\Action;
use App\Traits\TimeStamp;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AuditShippingOrderItemRepository::class)
 * @ORM\Table(name="audit__shipping_orders_items")
 */
class AuditShippingOrderItem
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
    private $boxId;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"Audit"})
     */
    private $productId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Audit"})
     */
    private $productName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Audit"})
     */
    private $boxName;

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

    public function getBoxId(): ?int
    {
        return $this->boxId;
    }
    public function setBoxId(?int $boxId): self
    {
        $this->boxId = $boxId;

        return $this;
    }

    public function getProductId(): ?int
    {
        return $this->productId;
    }
    public function setProductId(?int $productId): self
    {
        $this->productId = $productId;

        return $this;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }
    public function setProductName(?string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getBoxName(): ?string
    {
        return $this->boxName;
    }
    public function setBoxName(?string $boxName): self
    {
        $this->boxName = $boxName;

        return $this;
    }
}
