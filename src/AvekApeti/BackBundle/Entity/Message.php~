<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Message
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\MessageRepository")
 */
class Message
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
     * @var string
     *
     * @ORM\Column(name="item", type="string", length=255)
     */
    private $item;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @var boolean
     *
     * @ORM\Column(name="acc_lecture", type="boolean",nullable=true)
     */
    private $accLecture;

    /**
     *
     * @ORM\OneToOne(targetEntity="Utilisateur")
     */
    private $emetteur_user;
    /**
     *
     * @ORM\OneToOne(targetEntity="Utilisateur")
     */
    private $dest_user;
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
     * Set item
     *
     * @param string $item
     *
     * @return Message
     */
    public function setItem($item)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return string
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Message
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Message
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
     * Set accLecture
     *
     * @param boolean $accLecture
     *
     * @return Message
     */
    public function setAccLecture($accLecture)
    {
        $this->accLecture = $accLecture;

        return $this;
    }

    /**
     * Get accLecture
     *
     * @return boolean
     */
    public function getAccLecture()
    {
        return $this->accLecture;
    }

    /**
     * Set emetteurUser
     *
     * @param \AvekApeti\BackBundle\Entity\Utilisateur $emetteurUser
     *
     * @return Message
     */
    public function setEmetteurUser(\AvekApeti\BackBundle\Entity\Utilisateur $emetteurUser = null)
    {
        $this->emetteur_user = $emetteurUser;

        return $this;
    }

    /**
     * Get emetteurUser
     *
     * @return \AvekApeti\BackBundle\Entity\Utilisateur
     */
    public function getEmetteurUser()
    {
        return $this->emetteur_user;
    }

    /**
     * Set destUser
     *
     * @param \AvekApeti\BackBundle\Entity\Utilisateur $destUser
     *
     * @return Message
     */
    public function setDestUser(\AvekApeti\BackBundle\Entity\Utilisateur $destUser = null)
    {
        $this->dest_user = $destUser;

        return $this;
    }

    /**
     * Get destUser
     *
     * @return \AvekApeti\BackBundle\Entity\Utilisateur
     */
    public function getDestUser()
    {
        return $this->dest_user;
    }
}
