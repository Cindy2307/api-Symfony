<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Partenaire
 * @package App\Entity
 * @ORM\Entity
 */

class Partenaire
{

    // Propriétés

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @Groups({"partenaires:read", "magasins:read", "offres:read", "magasinsOffres:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique = true)
     * @Groups({"partenaires:read", "magasins:read", "offres:read", "magasinsOffres:read"})
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Offre", mappedBy="partenaire")
     * @Groups({"partenaires:read"})
     */
    private $offres;

    // Constructeur

    public function __construct()
    {
        $this->offres = new ArrayCollection();
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

    /**
     * @return Collection|Offre[]
     */

    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->commengts[] = $offre;
            $offre->setPartenaire($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->contains($offre)) {
            $this->offres->removeElement($offre);
            if ($offre->getPartenaire() === $this) {
                $offre->setPartenaire(null);
            }
        }
        return $this;
    }
}
