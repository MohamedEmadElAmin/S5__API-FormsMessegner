<?php

namespace App\Entity\Logs;

use App\Repository\Logs\AuditShippingOrderIssueRepository;
use App\Traits\Action;
use App\Traits\TimeStamp;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=AuditShippingOrderIssueRepository::class)
 * @ORM\Table(name="audit__shipping_orders_issues")
 */
class AuditShippingOrderIssue
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
    private $issueId;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"Audit"})
     */
    private $issueName;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"Audit"})
     */
    private $issueDetails;

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

    public function getIssueId(): ?int
    {
        return $this->issueId;
    }
    public function setIssueId(?int $issueId): self
    {
        $this->issueId = $issueId;

        return $this;
    }

    public function getIssueName(): ?string
    {
        return $this->issueName;
    }
    public function setIssueName(?string $issueName): self
    {
        $this->issueName = $issueName;

        return $this;
    }

    public function getIssueDetails(): ?string
    {
        return $this->issueDetails;
    }
    public function setIssueDetails(?string $issueDetails): self
    {
        $this->issueDetails = $issueDetails;

        return $this;
    }
}
