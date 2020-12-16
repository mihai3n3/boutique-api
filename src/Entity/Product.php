<?php

namespace App\Entity;

use App\Entity\TraitUtil\ActivatedTrait;
use App\Entity\TraitUtil\BlameableTrait;
use App\Entity\TraitUtil\EntityIdTrait;
use App\Entity\TraitUtil\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(
 *     uniqueConstraints={@UniqueConstraint(name="product_sku_unique", columns={"sku"})},
 *     name="product")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class Product
{
    use EntityIdTrait;
    use TimestampableTrait;
    use BlameableTrait;
    use ActivatedTrait;

    public const TVA = 19;

    public const STOCK_STATUS_OUT_OF_STOCK = 0;
    public const STOCK_STATUS_OUT_OF_STOCK_KEY = 'Out of srock';
    public const STOCK_STATUS_IN_STOCK = 1;
    public const STOCK_STATUS_IN_STOCK_KEY = 'In stock';
    public const STOCK_STATUS_TO_BE_ORDER = 2;
    public const STOCK_STATUS_TO_BE_ORDER_KEY = 'La comanda';
    public const STOCK_STATUS_PRE_ORDER = 3;
    public const STOCK_STATUS_PRE_ORDER_KEY = 'Pre-order';

    public const STOCK_STATUS = [
        self::STOCK_STATUS_IN_STOCK => self::STOCK_STATUS_IN_STOCK_KEY,
        self::STOCK_STATUS_TO_BE_ORDER => self::STOCK_STATUS_TO_BE_ORDER_KEY,
        self::STOCK_STATUS_PRE_ORDER => self::STOCK_STATUS_PRE_ORDER_KEY,
        self::STOCK_STATUS_OUT_OF_STOCK => self::STOCK_STATUS_OUT_OF_STOCK_KEY,
    ];

    public const STOCK_STATUS_KEY = [
        self::STOCK_STATUS_IN_STOCK_KEY => self::STOCK_STATUS_IN_STOCK,
        self::STOCK_STATUS_TO_BE_ORDER_KEY => self::STOCK_STATUS_TO_BE_ORDER,
        self::STOCK_STATUS_PRE_ORDER_KEY => self::STOCK_STATUS_PRE_ORDER,
        self::STOCK_STATUS_OUT_OF_STOCK_KEY => self::STOCK_STATUS_OUT_OF_STOCK,
    ];

    public const STOCK_STATUS_LABEL = [
        self::STOCK_STATUS_IN_STOCK => 'green',
        self::STOCK_STATUS_TO_BE_ORDER => 'yellow',
        self::STOCK_STATUS_PRE_ORDER => 'yellow',
        self::STOCK_STATUS_OUT_OF_STOCK => 'red',
    ];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=0,nullable=true)
     * @JMS\Type("float")
     */
    private $price;

    /**
     * @var float
     * @JMS\Type("float")
     */
    private $priceWithVat;

    /**
     * @ORM\Column(type="smallint",name="stock_status")
     * @JMS\Type("int")
     */
    private $stockStatus = self::STOCK_STATUS_OUT_OF_STOCK;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $stockStatusLabel;

    /**
     * @ORM\Column(type="string",length=5000, nullable=true)
     * @JMS\Type("string")
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="Brand")
     * @ORM\JoinColumn(name="brand_id", referencedColumnName="id")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("App\Entity\Brand")
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity="Category")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("App\Entity\Category")
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity="ProductGallery", mappedBy="product",cascade={"all"},fetch="EAGER")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("ArrayCollection<App\Entity\ProductGallery>")
     * @JMS\Groups({"details"})
     */
    private $gallery;

    /**
     * @ORM\OneToOne(targetEntity="ProductGallery", fetch="EAGER")
     * @ORM\JoinColumn(name="main_image_id", referencedColumnName="id")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("App\Entity\ProductGallery")
     */
    private $mainImage;

    /**
     * @ORM\OneToMany(targetEntity="ProductAttribute", mappedBy="product",fetch="EAGER")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("ArrayCollection<App\Entity\ProductAttribute>")
     * @JMS\Groups({"details"})
     */
    private $productAttributes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Type("string")
     */
    private $sku;
    /**
     * @ORM\Column(name="extra_info",type="string", length=5000, nullable=true)
     * @JMS\Type("string")
     * @JMS\Groups({"details"})
     */
    private $extraInfo;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $imagesFile;

    public function __construct()
    {
        $this->gallery = new ArrayCollection();
        $this->productAttributes = new ArrayCollection();
        $this->priceWithVat = $this->price * self::TVA;
        $this->stockStatusLabel = self::STOCK_STATUS_LABEL[$this->stockStatus];
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

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getPriceWithVat(): float
    {
        return $this->priceWithVat;
    }

    public function getStockStatusString(): string
    {
        return self::STOCK_STATUS[$this->stockStatus];
    }

    public function getStockStatus(): ?int
    {
        return $this->stockStatus;
    }

    public function setStockStatus(?int $stockStatus): self
    {
        $this->stockStatus = $stockStatus;
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

    public function getSku(): ?string
    {
        return $this->sku;
    }

    public function setSku(string $sku): self
    {
        $this->sku = $sku;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getGallery(): Collection
    {
        return $this->gallery;
    }

    public function addGallery(ProductGallery $gallery): self
    {
        if (!$this->gallery->contains($gallery)) {
            $this->gallery[] = $gallery;
            $gallery->setProduct($this);
        }

        return $this;
    }

    public function removeGallery(ProductGallery $gallery): self
    {
        if ($this->gallery->contains($gallery)) {
            $this->gallery->removeElement($gallery);
            // set the owning side to null (unless already changed)
            if ($gallery->getProduct() === $this) {
                $gallery->setProduct(null);
            }
        }

        return $this;
    }

    public function getMainImage(): ?ProductGallery
    {
        return $this->mainImage;
    }

    public function setMainImage(?ProductGallery $mainImage): self
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    public function getProductAttributes(): Collection
    {
        return $this->productAttributes;
    }

    public function addProductAttribute(ProductAttribute $productAttribute): self
    {
        if (!$this->productAttributes->contains($productAttribute)) {
            $this->productAttributes[] = $productAttribute;
            $productAttribute->setProduct($this);
        }

        return $this;
    }

    public function removeProductAttribute(ProductAttribute $productAttribute): self
    {
        if ($this->productAttributes->contains($productAttribute)) {
            $this->productAttributes->removeElement($productAttribute);
            // set the owning side to null (unless already changed)
            if ($productAttribute->getProduct() === $this) {
                $productAttribute->setProduct(null);
            }
        }

        return $this;
    }

    public function getImagesFile()
    {
        return $this->imagesFile;
    }

    public function setImagesFile($imagesFile): self
    {
        $this->imagesFile = $imagesFile;
        return $this;
    }

    public function getExtraInfo(): ?string
    {
        return $this->extraInfo;
    }

    public function setExtraInfo(?string $extraInfo): self
    {
        $this->extraInfo = $extraInfo;
        return $this;
    }

    public function getStockStatusLabel(): ?string
    {
        return $this->stockStatusLabel = self::STOCK_STATUS_LABEL[$this->stockStatus];
    }

    public function setStockStatusLabel(): self
    {
        $this->stockStatusLabel = self::STOCK_STATUS_LABEL[$this->stockStatus];;
        return $this;
    }
}
