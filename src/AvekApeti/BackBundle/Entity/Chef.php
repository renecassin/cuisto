<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chef
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Entity\ChefRepository")
 */
class Chef
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="zone_km", type="string", length=255)
     */
    private $zoneKm;
    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255)
     */
    private $city;
    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=255)
     */
    private $cp;
    /**
     *
     * @ORM\OneToOne(targetEntity="Utilisateur")
     */
    private $utilisateur;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Chef
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set zoneKm
     *
     * @param string $zoneKm
     *
     * @return Chef
     */
    public function setZoneKm($zoneKm)
    {
        $this->zoneKm = $zoneKm;

        return $this;
    }

    /**
     * Get zoneKm
     *
     * @return string
     */
    public function getZoneKm()
    {
        return $this->zoneKm;
    }

    /**
     * Set utilisateur
     *
     * @param \AvekApeti\BackBundle\Entity\Utilisateur $utilisateur
     *
     * @return Chef
     */
    public function setUtilisateur(\AvekApeti\BackBundle\Entity\Utilisateur $utilisateur = null)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \AvekApeti\BackBundle\Entity\Utilisateur
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Chef
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set cp
     *
     * @param string $cp
     *
     * @return Chef
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return string
     */
    public function getCp()
    {
        return $this->cp;
    }
}
