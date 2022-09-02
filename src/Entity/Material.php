<?php

namespace App\Entity;

use App\Repository\MaterialRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=MaterialRepository::class)
 */
class Material
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $material_name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $material_description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $material_img;

    /**
     * @var \DateTime $material_createdat
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $material_createdat;

    /**
     * @var \DateTime $material_updatedat
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $material_updatedat;

    /**
     * @ORM\ManyToOne(targetEntity=Association::class, inversedBy="materials")
     */
    private $asso;

    /**
     * @ORM\OneToMany(targetEntity=Deal::class, mappedBy="material")
     */
    private $deals;

    public function __construct()
    {
        $this->deals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMaterialName(): ?string
    {
        return $this->material_name;
    }

    public function setMaterialName(?string $material_name): self
    {
        $this->material_name = $material_name;

        return $this;
    }

    public function getMaterialDescription(): ?string
    {
        return $this->material_description;
    }

    public function setMaterialDescription(?string $material_description): self
    {
        $this->material_description = $material_description;

        return $this;
    }

    public function getMaterialImg(): ?string
    {
        return $this->material_img;
    }

    public function setMaterialImg(?string $material_img): self
    {
        $this->material_img = $material_img;

        return $this;
    }

    public function getMaterialCreatedat(): ?\DateTimeInterface
    {
        return $this->material_createdat;
    }

    // public function setMaterialCreatedat(?\DateTimeInterface $material_createdat): self
    // {
    //     $this->material_createdat = $material_createdat;

    //     return $this;
    // }

    public function getMaterialUpdatedat(): ?\DateTimeInterface
    {
        return $this->material_updatedat;
    }

    // public function setMaterialUpdatedat(?\DateTimeInterface $material_updatedat): self
    // {
    //     $this->material_updatedat = $material_updatedat;

    //     return $this;
    // }

    public function getAsso(): ?Association
    {
        return $this->asso;
    }

    public function setAsso(?Association $asso): self
    {
        $this->asso = $asso;

        return $this;
    }

    /**
     * @return Collection<int, Deal>
     */
    public function getDeals(): Collection
    {
        return $this->deals;
    }

    public function addDeal(Deal $deal): self
    {
        if (!$this->deals->contains($deal)) {
            $this->deals[] = $deal;
            $deal->setMaterial($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->removeElement($deal)) {
            // set the owning side to null (unless already changed)
            if ($deal->getMaterial() === $this) {
                $deal->setMaterial(null);
            }
        }

        return $this;
    }
}
