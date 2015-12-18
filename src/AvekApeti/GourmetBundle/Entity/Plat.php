<?php

namespace GourmetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class Plat
{

    private $id;


    private $name;

    private $price;

    private $quantity;

    private $UtilisateurId;


    public $tliv;

    public $tcoms;

    private $image;


    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Plat
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }



    public function setUtilisateurId(\AvekApeti\BackBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->UtilisateurId = $utilisateur->getId();

        return $this;
    }

    public function getUtilisateurId()
    {
        return $this->UtilisateurId;
    }

    public function setTliv(\AvekApeti\BackBundle\Entity\TypeLivraison $tliv = null)
    {
        $this->tliv = $tliv;

        return $this;
    }

    public function getTliv()
    {
        return $this->tliv;
    }

    public function setTcoms(\AvekApeti\BackBundle\Entity\TypeCommande $tcoms = null)
    {
        $this->tcoms = $tcoms;

        return $this;
    }

    public function getTcoms()
    {
        return $this->tcoms;
    }

    public function setImage(\AvekApeti\BackBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

}
