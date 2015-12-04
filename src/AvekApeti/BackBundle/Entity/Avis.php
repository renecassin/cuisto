<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Avis
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\AvisRepository")
 */
class Avis
{
    public function __construct()
    {
        $this->dateCreated = new \DateTime("now");

    }
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="note", type="integer")
     */
    private $note;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text")
     */
    private $comment;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean",nullable=true)
     */
    private $active;
    /**
     *
     * @ORM\OneToOne(targetEntity="Utilisateur")
     */
    private $utilisateur;
    /**
     * @ORM\ManyToOne(targetEntity="Utilisateur", inversedBy="avis")
     * @ORM\JoinColumn(name="utilisateur_avis_id", referencedColumnName="id", nullable=true)
     */
    private $utilisateurAvis;
    /**
     * @ORM\ManyToOne(targetEntity="Chef", inversedBy="avis")
     * @ORM\JoinColumn(name="chef_avis_id", referencedColumnName="id", nullable=true)
     */
    private $chefAvis;
    /**
     * @ORM\ManyToOne(targetEntity="Plat", inversedBy="avis")
     * @ORM\JoinColumn(name="plat_avis_id", referencedColumnName="id", nullable=true)
     */
    private $platAvis;

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
     * Set note
     *
     * @param integer $note
     *
     * @return Avis
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return integer
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Avis
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    /**
     * Get dateCreated
     *
     * @return \DateTime
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * Set comment
     *
     * @param string $comment
     *
     * @return Avis
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set active
     *
     * @param boolean $active
     *
     * @return Avis
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set utilisateur
     *
     * @param \AvekApeti\BackBundle\Entity\Utilisateur $utilisateur
     *
     * @return Avis
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
     * Set utilisateurAvis
     *
     * @param \AvekApeti\BackBundle\Entity\Utilisateur $utilisateurAvis
     *
     * @return Avis
     */
    public function setUtilisateurAvis(\AvekApeti\BackBundle\Entity\Utilisateur $utilisateurAvis = null)
    {
        $this->utilisateurAvis = $utilisateurAvis;

        return $this;
    }

    /**
     * Get utilisateurAvis
     *
     * @return \AvekApeti\BackBundle\Entity\Utilisateur
     */
    public function getUtilisateurAvis()
    {
        return $this->utilisateurAvis;
    }

    /**
     * Set chefAvis
     *
     * @param \AvekApeti\BackBundle\Entity\Chef $chefAvis
     *
     * @return Avis
     */
    public function setChefAvis(\AvekApeti\BackBundle\Entity\Chef $chefAvis = null)
    {
        $this->chefAvis = $chefAvis;

        return $this;
    }

    /**
     * Get chefAvis
     *
     * @return \AvekApeti\BackBundle\Entity\Chef
     */
    public function getChefAvis()
    {
        return $this->chefAvis;
    }

    /**
     * Set platAvis
     *
     * @param \AvekApeti\BackBundle\Entity\Plat $platAvis
     *
     * @return Avis
     */
    public function setPlatAvis(\AvekApeti\BackBundle\Entity\Plat $platAvis = null)
    {
        $this->platAvis = $platAvis;

        return $this;
    }

    /**
     * Get platAvis
     *
     * @return \AvekApeti\BackBundle\Entity\Plat
     */
    public function getPlatAvis()
    {
        return $this->platAvis;
    }
}
