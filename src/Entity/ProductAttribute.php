<?php

namespace App\Entity;

use App\Entity\TraitUtil\BlameableTrait;
use App\Entity\TraitUtil\EntityIdTrait;
use App\Entity\TraitUtil\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductAttributeRepository")
 * @ORM\Table(name="product_attribute")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class ProductAttribute
{
    use EntityIdTrait;
    use TimestampableTrait;
    use BlameableTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="productAttributes")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id",nullable=false)
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("App\Entity\Product")
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Attribute")
     * @ORM\JoinColumn(name="attribute_id", referencedColumnName="id",nullable=false)
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("ArrayCollection<App\Entity\Attribute>")
     */
    private $attribute;

    /**
     * @ORM\Column(type="json",nullable=true)
     * @JMS\Type("array")
     */
    private $value;

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getAttribute(): ?Attribute
    {
        return $this->attribute;
    }

    public function setAttribute(?Attribute $attribute): self
    {
        $this->attribute = $attribute;

        return $this;
    }
}
