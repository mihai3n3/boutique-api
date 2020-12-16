<?php

namespace App\Entity;

use App\Entity\TraitUtil\BlameableTrait;
use App\Entity\TraitUtil\EntityIdTrait;
use App\Entity\TraitUtil\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductGalleryRepository")
 * @ORM\Table(name="product_gallery")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class ProductGallery
{
    use EntityIdTrait;
    use TimestampableTrait;
    use BlameableTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="gallery")
     * @ORM\JoinColumn(name="product_id", referencedColumnName="id")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("App\Entity\Product")
     */
    private $product;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     * @JMS\Type("string")
     */
    private $path;

    /**
     * @ORM\Column(name="is_main", type="boolean",options={"comment":"Active:1 Inactive:0"})
     * @JMS\Type("bool")
     */
    private $isMain = false;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Type("string")
     */
    private $version;

    /**
     * @ORM\Column(type="string", name="file_name", nullable=true, length=255)
     * @JMS\Type("string")
     */
    private $fileName;

    /**
     * @ORM\Column(type="integer", name="size", nullable=true)
     * @JMS\Type("string")
     */
    private $size;


    public function __construct(array $data)
    {
        $arr = explode('/',$data['public_id']);
        $this->fileName = end($arr);
        $this->version = 'v'.$data['version'];
        $this->size = $data['bytes'];
    }

    public function getProduct() : ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product$product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getIsMain(): bool
    {
        return $this->isMain;
    }

    public function setIsMain($isMain): self
    {
        $this->isMain = $isMain;
        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getVersion(): ?string
    {
        return $this->version;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     * @return ProductGallery
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /** @TODO refactor */
    public function __toString()
    {
        $sku = (!empty($this->product)) ? $this->product->getSku().'/' : '';
        return 'https://res.cloudinary.com/promo-mall/image/upload/f_auto,g_auto/' . $this->version . '/products/'. $sku .$this->fileName.'.jpg';
    }

    public function getSize():int
    {
        return $this->size;
    }

    public function setSize(int $size):self
    {
        $this->size = $size;
        return $this;
    }
}
