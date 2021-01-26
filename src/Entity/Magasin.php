<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Magasin
 * @package App\Entity
 * @ORM\Entity
 */

 class Magasin{
   
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Offre", inversedBy="magasins")
     * @ORM\JoinColumn(onDelete="CASCADE")
     * @Groups({"magasins:read"})
     */
    private $offre;

    // Getters et setters

    public function getId() : ?int{
        return $this->id;
    }

    public function getName() : ?string{
        return $this->name;
    }

    public function setName(string $name) : self{
        $this->name = $name;
        return $this;
    }

    public function getAdress() : ?string{
        return $this->adress;
    }

    public function setAdress(string $adress) : self{
        $this->adress = $adress;
        return $this;
    }

    public function getOffre() : Offre{
        return $this->offre;
    }

    public function setOffre(?Offre $offre) : self{
        $this->offre = $offre;
        return $this;
    }
 }