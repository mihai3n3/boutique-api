<?php


namespace App\Entity\TraitUtil;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

trait BlameableTrait
{
    /**
     * @ORM\Column(name="created_by",nullable=true)
     * @JMS\Type("DateTime")
     */
    protected $createdBy;

    /**
     * @ORM\Column(name="updated_by",nullable=true)
     * @JMS\Type("DateTime")
     */
    protected $updatedBy;

    public function setCreatedBy(string $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getCreatedBy(): ?string
    {
        return $this->createdBy;
    }

    public function setUpdatedBy(string $updatedBy): self
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    public function getUpdatedBy(): ?string
    {
        return $this->updatedBy;
    }
}