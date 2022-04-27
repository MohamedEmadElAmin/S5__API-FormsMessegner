<?php

namespace App\Entity\ShippingOrder;

use App\Repository\ShippingOrders\ShippingBoxRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ShippingBoxRepository::class)
 * @ORM\Table(name="orders__shipping_boxes")
 */
class ShippingBox
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @Assert\Length
     * (
     *      min = 2,
     *      max = 254,
     *      minMessage = "name must be at least {{ limit }} characters long",
     *      maxMessage = "name cannot be longer than {{ limit }} characters long"
     * )
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
