<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttributeTemplateSectionRepository")
 * @ORM\Table(name="attribute_template_section")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 * @ORM\HasLifecycleCallbacks()
 */
class AttributeTemplateSection
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @JMS\Type("int")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AttributeTemplateSectionName", cascade={"persist", "remove" })
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("App\Entity\AttributeTemplateSectionName")
     */
    private $sectionName;

    /**
     * @var string
     * @JMS\Type("string")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\AttributeTemplate", inversedBy="section", cascade={"persist", "remove" })
     * @ORM\JoinColumn(name="template_id", referencedColumnName="id",nullable=false)
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("App\Entity\AttributeTemplate")
     */
    private $template;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Attribute", cascade={"persist", "remove"})
     * @ORM\JoinTable(name="attribute_template_section_attribute",
     *      joinColumns={@ORM\JoinColumn(name="section_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="attribute_id", referencedColumnName="id", unique=false)}
     *      )
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("ArrayCollection<App\Entity\Attribute>")
     */
    private $attribute;

    public function __construct()
    {
        $this->attribute = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSectionName(): ?AttributeTemplateSectionName
    {
        return $this->sectionName;
    }

    public function setSectionName(?AttributeTemplateSectionName $sectionName): self
    {
        $this->sectionName = $sectionName;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): AttributeTemplateSection
    {
        $this->name = $name;
        return $this;
    }

    public function getTemplate(): ?AttributeTemplate
    {
        return $this->template;
    }

    public function setTemplate(?AttributeTemplate $template): self
    {
        $this->template = $template;
        return $this;
    }

    public function getAttribute(): Collection
    {
        return $this->attribute;
    }

    public function addAttribute(Attribute $attribute): self
    {
        if (!$this->attribute->contains($attribute)) {
            $this->attribute[] = $attribute;
        }

        return $this;
    }

    public function removeAttribute(Attribute $attribute): self
    {
        if ($this->attribute->contains($attribute)) {
            $this->attribute->removeElement($attribute);
        }

        return $this;
    }

    /** @ORM\PostLoad() */
    public function initNotMappedFields()
    {
        $this->name = null;
        if (!empty($this->sectionName)) {
            $this->name = $this->sectionName->getName();
        }
    }

    public function __toString()
    {
        return 'section';
    }


}
