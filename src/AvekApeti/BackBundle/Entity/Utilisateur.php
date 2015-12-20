<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AvekApeti\BackBundle\Entity\Validator as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\EncoderAwareInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
/**
 * Utilisateur
 *
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\UtilisateurRepository")
 * @UniqueEntity("login", message="Login deja utilise")
 * @UniqueEntity("email", message="Email deja utilise")
 */
class Utilisateur implements UserInterface //, EquatableInterface
{
    public function __construct(Groupe $Groupe = null)
    {
        $this->dateCreated = new \DateTime("now");
        $this->groupe = $Groupe ; //Id de groupe par defaut doit correspondre a l'id du groupe d'un utilisateur enregistr� (gourmet)
        $this->salt = md5(uniqid(null, true)); // cr�ation d'un salt pour chaque utilisateur
        //$this->salt =null; // cr�ation d'un salt pour chaque utilisateur
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
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=255)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=4096)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255, nullable=true)
     */
    private $adress;

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
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255, nullable=true)
     */
    private $phone;
    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255, nullable=true)
     */
    private $salt;
    /**
     * @var int
     *
     * @ORM\Column(name="newsletter", type="boolean", nullable=true)
     */
    private $newsletter;


    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity="Groupe")
     * @ORM\JoinColumn(name="groupe_id",referencedColumnName="id",nullable=true)
     */
    private $groupe;
    /**
     * @var \DateTime
     * @ORM\Column(name="date_created", type="datetime")
     */
    private $dateCreated;
    /**
     * @var \DateTime
     * @ORM\Column(name="date_updated", type="datetime")
     */
    private $dateUpdated;
    /**
     * @ORM\OneToMany(targetEntity="Avis", mappedBy="utilisateurAvis", cascade={"remove"})
     */
    private $avis;

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
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Utilisateur
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Utilisateur
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Utilisateur
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set login
     *
     * @param string $login
     *
     * @return Utilisateur
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Utilisateur
     */
    public function setPassword($password)
    {


        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Utilisateur
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
     * Set salt
     *
     * @param string $salt
     *
     * @return Utilisateur
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
       // return $this->salt;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Utilisateur
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
     * @return Utilisateur
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

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Utilisateur
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set image
     *
     * @param \AvekApeti\BackBundle\Entity\Image $image
     *
     * @return Utilisateur
     */
    public function setImage(\AvekApeti\BackBundle\Entity\Image $image = null)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return \AvekApeti\BackBundle\Entity\Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set groupe
     *
     * @param \AvekApeti\BackBundle\Entity\Groupe $groupe
     *
     * @return Utilisateur
     */
    public function setGroupe(\AvekApeti\BackBundle\Entity\Groupe $groupe = null)
    {
        $this->groupe = $groupe;

        return $this;
    }

    /**
     * Get groupe
     *
     * @return \AvekApeti\BackBundle\Entity\Groupe
     */
    public function getGroupe()
    {
        return $this->groupe;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Utilisateur
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
     * Set dateUpdated
     *
     * @param \DateTime $dateUpdated
     *
     * @return Utilisateur
     */
    public function setDateUpdated($dateUpdated)
    {
        $this->dateUpdated = $dateUpdated;

        return $this;
    }

    /**
     * Get dateUpdated
     *
     * @return \DateTime
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }
    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function UpdateDateupdate()
    {
        return $this->dateUpdated = new \DateTime("now");
    }

    /**
     * Set newsletter
     *
     * @param string $newsletter
     *
     * @return Utilisateur
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return string
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
       // die(dump($this->groupe,$this->groupe));
        $roles = [];
      /*  foreach($this->groupe as $group)
        {
            array_push($roles, $group->getRole());
        }*/


            array_push($roles, $this->groupe->getRole());

        return $roles;
        //return $this->groupe->getRole();
        //return $groupe->getRole();
      //  return $this->groupe;
    }



    public function getUsername()
    {
        return $this->login;
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }


    /**
     * Add avi
     *
     * @param \AvekApeti\BackBundle\Entity\Avis $avi
     *
     * @return Utilisateur
     */
    public function addAvi(\AvekApeti\BackBundle\Entity\Avis $avi)
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
    /*public function isEqualTo(UserInterface $user)
    {
        return ($this->getUsername() == $user->getUsername() && serialize($this->getRoles()) == serialize($user->getRoles()));
    }*/
}
