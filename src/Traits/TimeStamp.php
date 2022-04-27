<?php

namespace App\Traits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

trait TimeStamp
{
    /**
     * @ORM\Column(type="datetime" , options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime" , options={"default"="CURRENT_TIMESTAMP"})
     */
    private $updatedAt;


    /**
     * @ORM\PrePersist()
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @ORM\PreUpdate()
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime();
    }
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @Groups({"Audit"})
     * @SerializedName("created_at")
     */
    public function getCreatedAtFormatted()
    {
        return $this->getCreatedAt()->format("Y-m-d H:i:s");
    }
}