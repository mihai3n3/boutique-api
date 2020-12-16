<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\UniqueConstraint;
use JMS\Serializer\Annotation as JMS;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AttributeTemplateRepository")
 * @ORM\Table(
 *     indexes={@ORM\Index(name="attribute_template_name", columns={"name"})},
 *     uniqueConstraints={@UniqueConstraint(name="attribute_template_name", columns={"name"})},
 *     name="attribute_template")
 * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
 */
class AttributeTemplate
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

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AttributeTemplateSection",mappedBy="template", cascade={"persist", "remove" }, fetch="EAGER")
     * @ORM\Cache(usage="NONSTRICT_READ_WRITE")
     * @JMS\Type("ArrayCollection<App\Entity\AttributeTemplateSection>")
     * @JMS\Groups({"details"})
     */
    private $section;

    public function __construct()
    {
        $this->section = new ArrayCollection();
    }
    public function getId(): ?int
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

    public function getSection(): ?Collection
    {
        return $this->section;
    }

    public function addSection(AttributeTemplateSection $section): self
    {
        if (!$this->section->contains($section)) {
            $this->$section[] = $section;
            $section->setTemplate($this);
        }

        return $this;
    }

    public function removeSection(AttributeTemplateSection $section): self
    {
        if ($this->section->contains($section)) {
            $this->section->removeElement($section);
            // set the owning side to null (unless already changed)
            if ($section->getTemplate() === $this) {
                $section->setTemplate(null);
            }
        }

        return $this;
    }
}
