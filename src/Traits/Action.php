<?php

namespace App\Traits;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

trait Action
{
    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"Audit"})
     */
    private string $action;


    public function setAction(string $action)
    {
        $this->action = $action;

    }
    public function getAction(): ?string
    {
        return $this->action;
    }
}