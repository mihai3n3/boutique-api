<?php


namespace App\Entity\TraitUtil;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/** @ORM\HasLifecycleCallbacks() */
trait SluggableTrait
{
    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Type("string")
     */
    private $slug;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }


    public function setSlug(?string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @ORM\PreUpdate
     * @ORM\PrePersist
     */
    public function updateSlug()
    {
        if (empty($this->slug)) {
            $this->slug = strtolower(str_replace(' ', '_', $this->name));
        }
        return $this;
    }
}