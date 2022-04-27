<?php

namespace App\Entity\Utilities;

use App\Repository\Utilities\IssueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=IssueRepository::class)
 * @ORM\Table(name="utilities__issues")
 */
class Issue
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
