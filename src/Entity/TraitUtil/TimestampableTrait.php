<?php

namespace App\Entity\TraitUtil;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/** @ORM\HasLifecycleCallbacks() */
trait TimestampableTrait
{
    /**
     * @ORM\Column(name="created_at", type="datetime",nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * @JMS\Groups({"details"})
     * @JMS\Type("Datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime",nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * @JMS\Groups({"details"})
     * @JMS\Type("Datetime")
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}