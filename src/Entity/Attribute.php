<?php

namespace App\Entity;

use App\Entity\TraitUtil\ActivatedTrait;
use App\Entity\TraitUtil\BlameableTrait;
use App\Entity\TraitUtil\EntityIdTrait;
use App\Entity\TraitUtil\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttributeRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="attribute",
 *     uniqueConstraints={@UniqueConstraint(name="attribute_name", columns={"name"})},
 * )
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class Attribute
{
    use EntityIdTrait;
    use TimestampableTrait;
    use BlameableTrait;
    use ActivatedTrait;

    public const USE_AS_FILTER = 1;
    public const NOT_USE_AS_FILTER = 0;

    public const REQUIRED_FALSE = 0;
    public const REQUIRED_TRUE = 1;


    public const TEXT_TYPE = 1;
    public const LIST_TYPE = 2;
    public const MULTIPLE_LIST_TYPE = 3;
    public const BOOL_TYPE = 4;

    public const TYPES = [
        self::TEXT_TYPE => 'Text type',
        self::LIST_TYPE => 'List type',
        self::MULTIPLE_LIST_TYPE => 'Multiple selection type',
        self::BOOL_TYPE => 'Yes/No',
    ];

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     * @JMS\Type("int")
     */
    private $position = 1;
    /**
     * @ORM\Column(name="use_as_filter",type="boolean")
     * @JMS\Type("bool")
     */
    private $useAsFilter = self::NOT_USE_AS_FILTER;
    /**
     * @ORM\Column(type="smallint")
     * @JMS\Type("int")
     */
    private $type = self::TEXT_TYPE;

    /**
     * @ORM\Column(type="string", length=5000, nullable=true)
     * @JMS\Type("string")
     */
    private $options;
    /**
     * @ORM\Column(name="is_required",type="boolean")
     * @JMS\Type("bool")
     */
    private $isRequired = self::REQUIRED_TRUE;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $typeAsString;

    public function getId()
    {
        return $this->id;
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

        return $this;
    }

    public function getOptions(): ?string
    {
        return $this->options;
    }

    public function setOptions(?string $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getUseAsFilter(): ?bool
    {
        return $this->useAsFilter;
    }

    public function setUseAsFilter(bool $useAsFilter): self
    {
        $this->useAsFilter = $useAsFilter;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getIsRequired(): ?bool
    {
        return $this->isRequired;
    }

    public function setIsRequired(bool $isRequired): self
    {
        $this->isRequired = $isRequired;

        return $this;
    }

    public function __toString()
    {
        return $this->name;
    }

    public function getTypeAsString(): string
    {
        return $this->typeAsString;
    }

    /** @ORM\PostLoad() */
    public function initNotMappedFields()
    {
        $this->typeAsString = static::TYPES[$this->type];
    }
}
