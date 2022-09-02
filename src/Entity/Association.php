<?php

namespace App\Entity;

use App\Repository\AssociationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AssociationRepository::class)
 */
class Association
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
    private $association_name;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="asso")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Material::class, mappedBy="asso")
     */
    private $materials;

    /**
     * @ORM\OneToMany(targetEntity=Deal::class, mappedBy="asso")
     */
    private $deals;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $association_phone;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $association_address;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $association_city;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    private $association_zipcode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $association_img;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $association_website;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->materials = new ArrayCollection();
        $this->deals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssociationName(): ?string
    {
        return $this->association_name;
    }

    public function setAssociationName(?string $association_name): self
    {
        $this->association_name = $association_name;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAsso($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAsso() === $this) {
                $user->setAsso(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Material>
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(Material $material): self
    {
        if (!$this->materials->contains($material)) {
            $this->materials[] = $material;
            $material->setAsso($this);
        }

        return $this;
    }

    public function removeMaterial(Material $material): self
    {
        if ($this->materials->removeElement($material)) {
            // set the owning side to null (unless already changed)
            if ($material->getAsso() === $this) {
                $material->setAsso(null);
            }
        }

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
            $deal->setAsso($this);
        }

        return $this;
    }

    public function removeDeal(Deal $deal): self
    {
        if ($this->deals->removeElement($deal)) {
            // set the owning side to null (unless already changed)
            if ($deal->getAsso() === $this) {
                $deal->setAsso(null);
            }
        }

        return $this;
    }

    public function getAssociationPhone(): ?string
    {
        return $this->association_phone;
    }

    public function setAssociationPhone(?string $association_phone): self
    {
        $this->association_phone = $association_phone;

        return $this;
    }

    public function getAssociationAddress(): ?string
    {
        return $this->association_address;
    }

    public function setAssociationAddress(?string $association_address): self
    {
        $this->association_address = $association_address;

        return $this;
    }

    public function getAssociationCity(): ?string
    {
        return $this->association_city;
    }

    public function setAssociationCity(?string $association_city): self
    {
        $this->association_city = $association_city;

        return $this;
    }

    public function getAssociationZipcode(): ?string
    {
        return $this->association_zipcode;
    }

    public function setAssociationZipcode(?string $association_zipcode): self
    {
        $this->association_zipcode = $association_zipcode;

        return $this;
    }

    public function getAssociationImg(): ?string
    {
        return $this->association_img;
    }

    public function setAssociationImg(?string $association_img): self
    {
        $this->association_img = $association_img;

        return $this;
    }

    public function getAssociationWebsite(): ?string
    {
        return $this->association_website;
    }

    public function setAssociationWebsite(?string $association_website): self
    {
        $this->association_website = $association_website;

        return $this;
    }
}
