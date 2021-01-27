<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Magasin
 * @package App\Entity
 * @ORM\Entity
 */

class Magasin
{

    // Propriétés

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @Groups({"partenaires:read", "offres:read", "magasins:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"partenaires:read", "offres:read", "magasins:read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"partenaires:read", "offres:read", "magasins:read"})
     */
    private $adress;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Offre", inversedBy="magasins")
     * @ORM\JoinTable(name="offres_magasins")
     * @Groups({"magasins:read", "magasinsOffres:read"})
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;
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
            $this->offres[] = $offre;
            $offre->addMagasin($this);
        }
        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->contains($offre)) {
            $this->offres->removeElement($offre);
        }
        return $this;
    }
}
