<?php

namespace GourmetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class PlatPanier
{

    private $plat;

    private $quantity;

    public $tliv;

    public $tcoms;


    public function setPlat(\AvekApeti\BackBundle\Entity\Plat $plat)
    {
        $this->plat = $plat;

        return $this;
    }

    public function getPlat()
    {
        return $this->plat;
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

}
