<?php

namespace App\Entity;

use App\Entity\TraitUtil\ActivatedTrait;
use App\Entity\TraitUtil\BlameableTrait;
use App\Entity\TraitUtil\EntityIdTrait;
use App\Entity\TraitUtil\SluggableTrait;
use App\Entity\TraitUtil\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="category_name", columns={"name"})},
 *     uniqueConstraints={@UniqueConstraint(name="category_name", columns={"name"})},
 *     name="category")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 * @ORM\HasLifecycleCallbacks()
 */
class Category
{
    use EntityIdTrait;
    use TimestampableTrait;
    use BlameableTrait;
    use ActivatedTrait;
    use SluggableTrait;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @JMS\Type("string")
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id",nullable=true)
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Groups({"details"})
     * @JMS\Type("App\Entity\Category")
     */
    private $parent;

    /**
     * @ORM\Column(type="integer",name="total_product_count")
     * @JMS\Type("integer")
     */
    private $totalProductCount = 0;

    /**
     * @ORM\Column(type="integer",name="active_product_count")
     * @JMS\Type("integer")
     */
    private $activeProductCount = 0;

    /**
     * @ORM\Column(type="string",length=5000)
     * @JMS\Type("string")
     */
    private $description;

    /**
     * @ORM\Column(name="meta_description", type="string",length=5000,nullable=true)
     * @JMS\Type("string")
     * @JMS\SerializedName("metaDescription")
     */
    private $metaDescription;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AttributeTemplate")
     * @ORM\JoinColumn(name="attribute_template", referencedColumnName="id")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Groups({"details"})
     * @JMS\Type("App\Entity\AttributeTemplate")
     * @JMS\SerializedName("attributeTemplate")
     */
    private $attributeTemplate;

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getParent(): ?Category
    {
        return $this->parent;
    }

    public function setParent(Category $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getTotalProductCount(): ?int
    {
        return $this->totalProductCount;
    }

    public function setTotalProductCount(?int $totalProductCount): self
    {
        $this->totalProductCount = $totalProductCount;

        return $this;
    }

    public function getActiveProductCount(): ?int
    {
        return $this->activeProductCount;
    }

    public function setActiveProductCount(?int $activeProductCount): self
    {
        $this->activeProductCount = $activeProductCount;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(?string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;
        return $this;
    }

    public function getAttributeTemplate(): ?AttributeTemplate
    {
        return $this->attributeTemplate;
    }

    public function setAttributeTemplate(?AttributeTemplate $attributeTemplate): self
    {
        $this->attributeTemplate = $attributeTemplate;
        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
