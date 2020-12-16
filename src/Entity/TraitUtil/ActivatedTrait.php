<?php

namespace App\Entity\TraitUtil;

use JMS\Serializer\Annotation as JMS;
use Doctrine\ORM\Mapping as ORM;

trait ActivatedTrait
{
    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=false, options={"default":"1"})
     * @JMS\Type("bool")
     */
    protected $isActive = true;

    public function isIsActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }
}