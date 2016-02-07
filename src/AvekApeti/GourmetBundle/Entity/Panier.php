<?php

namespace AvekApeti\GourmetBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


class Panier
{

    public function __construct()
    {
        $tableauPlats = [];
        $tableauMenus = [];


    }

    private $id ;

    private $chefSelect;

    private $tableauPlats;

    private $tableauPlatsTotal = 0;

    private $tableauPlatsTotalHT = 0;

    private $tableauMenus;
    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    public function getChefSelect(){
        return $this->chefSelect;

    }
    public function setChefSelect($Chef){
        $this->chefSelect = $Chef;

    }
    public function getTableauPlats(){
        return $this->tableauPlats;
    }
    public function getTableauMenus(){
        return $this->tableauMenus;
    }
    public function addTableauPlats(\AvekApeti\GourmetBundle\Entity\PlatPanier $PlatPanier){
        $this->tableauPlats[$PlatPanier->getPlat()->getId()] = $PlatPanier;
        return $this;
    }
    public function addTableauMenus(\AvekApeti\GourmetBundle\Entity\MenuPanier $MenuPanier){
        $this->tableauMenus[] = $MenuPanier;
        return $this;
    }
    public function supTableauPlats($index){
        unset($this->tableauPlats[$index]);
        $this->tableauPlats = array_values($this->tableauPlats);
        if(count($this->tableauPlats) == 0)
        {
            $this->tableauPlats = null;
        }
        $this->verifNull();
        return $this;
    }
    public function supTableauMenus($index){
        unset($this->tableauMenus[$index]);
        $this->tableauMenus = array_values($this->tableauMenus);
        if(count($this->tableauMenus) == 0)
        {
            $this->tableauMenus = null;
        }
        $this->verifNull();
        return $this;
    }
    public function getCount(){
        $c=0;
        if(count($this->getTableauPlats()) != 0) {
            foreach ($this->getTableauPlats() as $platPanier) {
                $c = $c + $platPanier->getQuantity();
            }
        }
      if(count($this->getTableauMenus()) != 0){
        foreach ($this->getTableauMenus() as $menuPanier){
            $c = $c + $menuPanier->getQuantity();
        }
      }
        return $c;
    }

    private function verifNull()
    {
        if($this->tableauMenus == null && $this->tableauPlats == null)
        {
            $this->chefSelect = null;
        }
    }

    /**
     * @return mixed
     */
    public function getTableauPlatsTotal()
    {
        return $this->tableauPlatsTotal;
    }

    /**
     * @param mixed $tableauPlatsTotal
     */
    public function setTableauPlatsTotal($tableauPlatsTotal)
    {
        $this->tableauPlatsTotal = $tableauPlatsTotal;
    }

    public function addTableauPlatsTotal($price)
    {
        $this->tableauPlatsTotal += $price;
    }

    public function supTableauPlatsTotal($price)
    {
        $this->tableauPlatsTotal -= $price;
    }


    /**
     * @return mixed
     */
    public function getTableauPlatsTotalHT()
    {
        return $this->tableauPlatsTotalHT;
    }

    /**
     * @param mixed $tableauPlatsTotal
     */
    public function setTableauPlatsTotalHT($tableauPlatsTotal)
    {
        $this->tableauPlatsTotalHT = $tableauPlatsTotal;
    }

    public function addTableauPlatsTotalHT($price)
    {
        $this->tableauPlatsTotalHT += $price;
    }

    public function supTableauPlatsTotalHT($price)
    {
        $this->tableauPlatsTotalHT -= $price;
    }
}

