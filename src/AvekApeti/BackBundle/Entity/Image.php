<?php

namespace AvekApeti\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
/**
 * Image
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AvekApeti\BackBundle\Repository\ImageRepository")
 */
class Image
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="Utilisateur")
     * @ORM\Column(name="user", type="integer")
     */
    private $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateCreated", type="datetime")
     */
    private $dateCreated;

    /**
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpg", "image/jpeg","image/png","image/gif"},
     *     mimeTypesMessage = "Please upload a valid IMG"
     * )
     */
    private $file;
    //Variable permettant de savoir si on est en mode edition ou non
    private $oldName;
    private $routewebdir ="uploads/";

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
     * Set name
     *
     * @param string $name
     *
     * @return Image
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

    /**
     * Set src
     *
     * @param string $src
     *
     * @return Image
     */
    public function setSrc($src)
    {
        $this->src = $src;

        return $this;
    }

    /**
     * Get src
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * Set routewebdir
     *
     * @param string $routewebdir
     *
     * @return string
     */
    public function setRoutewebdir($routewebdir)
    {
        $this->routewebdir = $routewebdir;

        return $this;
    }

    /**
     * Get routewebdir
     *
     * @return string
     */
    public function getRoutewebdir()
    {
        return $this->routewebdir;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Image
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set dateCreated
     *
     * @param \DateTime $dateCreated
     *
     * @return Image
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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function upload()
    {
        if(!ISSET($this->file))
            return;

        $nameImage = time()."-".$this->file->getClientOriginalName();
        $this->name=$nameImage;
        $this->src=$nameImage;
        $this->file->move(
            __DIR__.'/../../../../web/'.$this->routewebdir,
            $nameImage
        );




        if(!empty($this->oldName))
            if(file_exists(__DIR__.'/../../../../web/'.$this->routewebdir.'/'.$this->oldName))
            {

                unlink(__DIR__.'/../../../../web/'.$this->routewebdir.'/'.$this->oldName);

            }

    }

    public function setFile(UploadedFile $file)
    {
        $this->file = $file;
        //Si j'ai deja un nom(edition), je sauvegarde celui ci dans une variable oldname
        if(null != $this->getFile())
        {
            // On effectue une modification fictive pour obliger doctrine � croire qu'il y a eu une modif et donc
            // faire la mise � jour de mon objet Image
            $this->oldName = $this->name;
            $this->name = "changement";
        }
        return $this;
    }

    /**
     * Set user
     *
     * @param integer $user
     *
     * @return Image
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return integer
     */
    public function getUser()
    {
        return $this->user;
    }
    public function getFile()
    {
        return $this->file;
    }

    public function webPath($thumb = null)
    {
        if ($thumb)
        {
            if (file_exists(__DIR__.'/../../../../web/'.$this->routewebdir.'/'.$thumb.'-'.$this->name))
            {
                return $this->routewebdir.'/'.$thumb.'-'.$this->name;
            }
        }
        if (file_exists(__DIR__.'/../../../../web/'.$this->routewebdir.$this->name))
        {
            return $this->routewebdir.$this->name;
        }
        // Photo par défaut
        return null;
    }
}
