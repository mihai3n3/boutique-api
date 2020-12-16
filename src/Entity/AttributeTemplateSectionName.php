<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttributeTemplateSectionNameRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="attribute_template_section_name", columns={"name"})},
 *     uniqueConstraints={@UniqueConstraint(name="attribute_template_section_name_name", columns={"name"})},
 *     name="attribute_template_section_name")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class AttributeTemplateSectionName
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Type("int")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @JMS\Type("string")
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
