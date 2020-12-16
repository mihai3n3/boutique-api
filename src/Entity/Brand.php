<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\TraitUtil\ActivatedTrait;
use App\Entity\TraitUtil\BlameableTrait;
use App\Entity\TraitUtil\EntityIdTrait;
use App\Entity\TraitUtil\TimestampableTrait;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 * @ORM\Table(indexes={@ORM\Index(name="brand_name", columns={"name"})}, name="brand")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class Brand
{
    use EntityIdTrait;
    use TimestampableTrait;
    use BlameableTrait;
    use ActivatedTrait;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Type("string")
     */
    private $logo;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     * @JMS\Type("string")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Type("string")
     *
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @JMS\Type("string")
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     * @JMS\Type("string")
     */
    private $metaDescription;

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
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

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;
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
}
