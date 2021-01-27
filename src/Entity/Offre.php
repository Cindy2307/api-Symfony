<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Offre
 * @package App\Entity
 * @ORM\Entity
 */

class Offre
{

    // Propriétés

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @Groups({"partenaires:read", "offres:read", "magasins:read", "magasinsOffres:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"partenaires:read", "offres:read", "magasins:read", "magasinsOffres:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Groups({"partenaires:read", "offres:read", "magasins:read", "magasinsOffres:read"})
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"partenaires:read", "offres:read", "magasins:read", "magasinsOffres:read"})
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Partenaire", inversedBy="offres")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Groups({"magasins:read", "offres:read", "magasinsOffres:read"})
     */
    private $partenaire;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Magasin", mappedBy="offres")
     * @ORM\JoinTable(name="offres_magasins")
     * @Groups({"partenaires:read", "offres:read"})
     */
    private $magasins;

    // Constructeur

    public function __construct()
    {
        $this->magasins = new ArrayCollection();
    }

    // Getters et setters

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent($content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getPartenaire(): ?Partenaire
    {
        return $this->partenaire;
    }

    public function setPartenaire(?Partenaire $partenaire): self
    {
        $this->partenaire = $partenaire;
        return $this;
    }

    /**
     * @return Collection|Magasin[]
     */

    public function getMagasins(): Collection
    {
        return $this->magasins;
    }

    public function addMagasin(Magasin $magasin): self
    {
        if (!$this->magasins->contains($magasin)) {
            $this->magasins[] = $magasin;
            $magasin->addOffre($this);
        }
        return $this;
    }

    public function removeMagasin(Magasin $magasin): self
    {
        if ($this->magasins->contains($magasin)) {
            $this->magasins->removeElement($magasin);
        }
        return $this;
    }
}
