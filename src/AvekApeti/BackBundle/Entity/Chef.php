<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

/**
 * Chef
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\ChefRepository")
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
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="zone_km", type="string", length=255, nullable=true)
     */
    private $zoneKm;
    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=true)
     */
    private $city;
    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=255, nullable=true)
     */
    private $cp;
    /**
     *
     * @ORM\OneToOne(targetEntity="Utilisateur")
     */
    private $utilisateur;

    /**
     * @ORM\OneToMany(targetEntity="Avis", mappedBy="chefAvis", cascade={"remove"})
     */
    private $avis;
    /**
     * @var integer
     *
     * @ORM\Column(name="professionel", type="boolean", nullable=true)
     */
    private $professionnel;
    /**
     * @var string
     *
     * @ORM\Column(name="siret", type="string", length=255, nullable=true)
     */
    private $siret;


    /**
     * @var float
     *
     * @ORM\Column(name="lng", type="float", nullable=true)
     */
    private $lng;


    /**
     * @var float
     *
     * @ORM\Column(name="lat", type="float", nullable=true)
     */
    private $lat;
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

    public function getLng()
    {
        return $this->lng;
    }

    public function setLng($lng)
    {
        $this->lng = $lng;

        return $this;
    }

    public function getLat()
    {
        return $this->lat;
    }
    public function setLat($lat)
    {
        $this->lat = $lat;

        return $this;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->avis = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add avi
     *
     * @param \AvekApeti\BackBundle\Entity\Avis $avi
     *
     * @return Chef
     */
    public function addAvi(\AvekApeti\BackBundle\Entity\avis $avi)
    {
        $this->avis[] = $avi;

        return $this;
    }

    /**
     * Remove avi
     *
     * @param \AvekApeti\BackBundle\Entity\Avis $avi
     */
    public function removeAvi(\AvekApeti\BackBundle\Entity\Avis $avi)
    {
        $this->avis->removeElement($avi);
    }

    /**
     * Get avis
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAvis()
    {
        return $this->avis;
    }

    /**
     * Set professionnel
     *
     * @param boolean $professionnel
     *
     * @return Chef
     */
    public function setProfessionnel($professionnel)
    {
        $this->professionnel = $professionnel;

        return $this;
    }

    /**
     * Get professionnel
     *
     * @return boolean
     */
    public function getProfessionnel()
    {
        return $this->professionnel;
    }

    /**
     * Set siret
     *
     * @param string $siret
     *
     * @return Chef
     */
    public function setSiret($siret)
    {
        $this->siret = $siret;

        return $this;
    }

    /**
     * Get siret
     *
     * @return string
     */
    public function getSiret()
    {
        return $this->siret;
    }

    /**
     * @Assert\Callback
     */
    public function validate(ExecutionContextInterface $context)
    {   
        if (!empty($this->adress) && !empty($this->city) && !empty($this->cp))
        {
            $urlGoogle = 'http://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($this->adress.', '.$this->cp.', '.$this->city);
            if ($this->get_http_response_code($urlGoogle) == '200')
            {
                $json = file_get_contents($urlGoogle);
                $parsedjson = json_decode($json, true);
                if (!empty($parsedjson['status']) && 'OK' == $parsedjson['status'])
                {
                    return;
                }
            }
        }

        $context->buildViolation('Veuillez vérifier votre adresse, code postal et ville')
                ->atPath('adress')
                ->addViolation();
    }


    private function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }
}


