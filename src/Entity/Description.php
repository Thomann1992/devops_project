<?php

namespace App\Entity;

use App\Repository\DescriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use phpDocumentor\Reflection\Types\Nullable;

#[ORM\Entity(repositoryClass: DescriptionRepository::class)]
class Description
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    private ?string $URL = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $OnePassword = null;

    #[ORM\ManyToMany(targetEntity: Department::class, inversedBy: 'descriptions')]
    private Collection $Departments;

    // // #[Gedmo\Timestampable(on: 'create')]
    // #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    // private ?\DateTimeInterface $dateCreated = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $additionalInfo = null;

    // #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    // //#[Gedmo\Timestampable(on: 'change')]
    // private $lastModified = null;

    /**
     * @var \DateTime
     */
    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(name: 'created', type: Types::DATE_MUTABLE)]
    private $created;

    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'updated', type: Types::DATETIME_MUTABLE)]
    #[Gedmo\Timestampable]
    private $updated;

    /**
     * @var \DateTime
     */
    #[ORM\Column(name: 'content_changed', type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Gedmo\Timestampable(on: 'change', field: ['title', 'body'])]
    private $contentChanged;


    public function __construct()
    {
        $this->Departments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->Name;
    }

    public function setName(string $Name): self
    {
        $this->Name = $Name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getURL(): ?string
    {
        return $this->URL;
    }

    public function setURL(string $URL): self
    {
        $this->URL = $URL;

        return $this;
    }

    public function getOnePassword(): ?string
    {
        return $this->OnePassword;
    }

    public function setOnePassword(?string $OnePassword): self
    {
        $this->OnePassword = $OnePassword;

        return $this;
    }

    /**
     * @return Collection<int, Department>
     */
    public function getDepartments(): Collection
    {
        return $this->Departments;
    }

    public function addDepartment(Department $department): self
    {
        if (!$this->Departments->contains($department)) {
            $this->Departments->add($department);
        }

        return $this;
    }

    public function removeDepartment(Department $department): self
    {
        $this->Departments->removeElement($department);

        return $this;
    }

    public function __toString()
    {
        return $this->Name;
    }

    // public function getDateCreated(): ?\DateTimeInterface
    // {
    //     return $this->dateCreated;
    // }

    // public function setDateCreated(\DateTimeInterface $dateCreated): self
    // {
    //     $this->dateCreated = $dateCreated;

    //     return $this;
    // }

    public function getAdditionalInfo(): ?string
    {
        return $this->additionalInfo;
    }

    public function setAdditionalInfo(?string $additionalInfo): self
    {
        $this->additionalInfo = $additionalInfo;

        return $this;
    }

    // public function getLastModified(): ?\DateTimeInterface
    // {
    //     return $this->lastModified;
    // }

    // public function setLastModified(?\DateTimeInterface $lastModified): self
    // {
    //     $this->lastModified = $lastModified;

    //     return $this;
    // }

    public function getCreated()
    {
        return $this->created;
    }

    public function getUpdated()
    {
        return $this->updated;
    }

    public function getContentChanged()
    {
        return $this->contentChanged;
    }
}
