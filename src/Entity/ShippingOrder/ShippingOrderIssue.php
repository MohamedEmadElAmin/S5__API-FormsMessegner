<?php

namespace App\Entity\ShippingOrder;

use App\Entity\Utilities\Issue;
use App\Repository\ShippingOrders\ShippingOrderIssueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ShippingOrderIssueRepository::class)
 * @ORM\Table(name="orders__shipping_orders_issues")
 */
class ShippingOrderIssue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Type("string")
     */
    private $details;

    /**
     * @ORM\ManyToOne(targetEntity=ShippingOrder::class)
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank()
     */
    private $shippingOrder;

    /**
     * @ORM\ManyToOne(targetEntity=Issue::class)
     * @Assert\NotBlank()
     */
    private $issue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }
    public function setDetails(?string $details): self
    {
        $this->details = $details;

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

    public function getIssue(): ?Issue
    {
        return $this->issue;
    }
    public function setIssue(?Issue $issue): self
    {
        $this->issue = $issue;

        return $this;
    }
}
