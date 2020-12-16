<?php

namespace App\Entity\TraitUtil;
use JMS\Serializer\Annotation as JMS;

trait EntityIdTrait
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Type("int")
     */
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}