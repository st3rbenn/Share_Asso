<?php

namespace App\Entity;

use App\Repository\DealRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=DealRepository::class)
 */
class Deal
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var \DateTime $deal_createdat
     * 
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deal_createdat;

    /**
     * @var \DateTime $deal_updatedat
     * 
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deal_updatedat;

    /**
     * @ORM\ManyToOne(targetEntity=Material::class, inversedBy="deals")
     */
    private $material;

    /**
     * @ORM\ManyToOne(targetEntity=Association::class, inversedBy="deals")
     */
    private $asso;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDealCreatedat(): ?\DateTimeInterface
    {
        return $this->deal_createdat;
    }

    // public function setDealCreatedat(?\DateTimeInterface $deal_createdat): self
    // {
    //     $this->deal_createdat = $deal_createdat;

    //     return $this;
    // }

    public function getDealUpdatedat(): ?\DateTimeInterface
    {
        return $this->deal_updatedat;
    }

    // public function setDealUpdatedat(?\DateTimeInterface $deal_updatedat): self
    // {
    //     $this->deal_updatedat = $deal_updatedat;

    //     return $this;
    // }

    public function getMaterial(): ?Material
    {
        return $this->material;
    }

    public function setMaterial(?Material $material): self
    {
        $this->material = $material;

        return $this;
    }

    public function getAsso(): ?Association
    {
        return $this->asso;
    }

    public function setAsso(?Association $asso): self
    {
        $this->asso = $asso;

        return $this;
    }
}
