<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * @ORM\Entity
 * @UniqueEntity(fields={"mail"}, message="Este mail ya se encuentra registrado"),
 * @ORM\Entity(repositoryClass="Kells\Bundle\FrontBundle\EntityRepository\LicenseeRepository")
 * @ORM\Table(name="licensees") 
 */
class Licensee implements UserInterface {
	
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	
	/**
     * @ORM\Column(type="boolean")
     */
	protected $status;
	
	/**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
	protected $socialReason;
	/**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
	protected $fantasyName;
	
	/**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
	protected $contactName;
	
	/**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
	protected $telephone;
	
	/**
     * @ORM\Column(type="string", length=11, unique=true)
     */
	protected $cuit;
	
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(max = 4096)
     */
    protected $password;
    
    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $mail;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $token;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $address;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $web;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $facebook;

    
    /**
     * @ORM\ManyToOne(targetEntity="City", inversedBy="cities")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     **/
    protected $city;
    
    protected $cityId;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function setSocialReason($socialReason) {
		$this->socialReason = $socialReason;
	}
	
	public function getSocialReason() {
		return $this->socialReason;
	}
	
	public function getFantasyName() {
		return $this->fantasyName;
	}
	
	public function setFantasyName($fantasyName) {
		$this->fantasyName = $fantasyName;
	}
	
	public function getCuit() {
		return $this->cuit;
	}
	
	public function setCuit($cuit) {
		$this->cuit = $cuit;
	}
	

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }
    
	public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }
	
	public function getMail()
    {
        return $this->mail;
    }

    public function setMail($mail)
    {
        $this->mail = $mail;
    }
    
	public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
    
	public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
    }
    
	
	/**
     * @ORM\ManyToMany(targetEntity="Rol")
     * @ORM\JoinTable(name="licensee_rol",
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id")}
     * )
     */
    protected $roles;
	
    /**
     * @ORM\Column(name="salt", type="string", length=255)
     */
    protected $salt = "";
    
    /**
     * @ORM\OneToMany(targetEntity="Car", mappedBy="licensee", cascade="remove")
     **/
    protected $cars;


    /**
     * @ORM\OneToOne(targetEntity="ImageFile", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="mandatoryImage_id", referencedColumnName="id")
     **/
    protected $image;

    /**
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param mixed $image
     */
    public function setImage($image)
    {
        $this->image = $image;
    }
    
     /**
     * Add roles
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Rol $roles
     * @return User
     */
    public function addRole(\Kells\Bundle\FrontBundle\Entity\Rol $roles)
    {
        $this->roles[] = $roles;

        return $this;
    }

    /**
     * Remove roles
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Rol $roles
     */
    public function removeRole(\Kells\Bundle\FrontBundle\Entity\Rol $roles)
    {
        $this->roles->removeElement($roles);
    }

    /**
     * Get roles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRoles()
    {
        return array('ROLE_LICENSEE');
    }
    
	public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }
    
     public function eraseCredentials()
    {
    }
    
   

    /**
     * Add cars
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Car $cars
     * @return User
     */
    public function addCar(\Kells\Bundle\FrontBundle\Entity\Car $cars)
    {
        $this->cars[] = $cars;

        return $this;
    }
    
 /**
     * Remove cars
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Car $cars
     */
    public function removeCar(\Kells\Bundle\FrontBundle\Entity\Car $cars)
    {
        $this->cars->removeElement($cars);
    }

    /**
     * Get cars
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCars()
    {
        return $this->cars;
    }
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
        $this->cars = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
 
	/**
     * Get username
     *
     * @return string 
     */
    public function getUsername()
    {
        return $this->mail;
    }
    
	public function getName() {
    	return $this->getSocialReason();
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
    
	public function setCity($city) {
    	return $this->city = $city;
    }
    
 public function getCityId()
    {
        return $this->cityId;
    }
    
	public function setCityId($cityId) {
    	return $this->cityId = $cityId;
    }

 	public function getContactName()
    {
        return $this->contactName;
    }
    
	public function setContactName($contactName) {
    	return $this->contactName = $contactName;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getWeb()
    {
        return $this->web;
    }

    /**
     * @param mixed $web
     */
    public function setWeb($web)
    {
        $this->web = $web;
    }

    /**
     * @return mixed
     */
    public function getFacebook()
    {
        return $this->facebook;
    }

    /**
     * @param mixed $facebook
     */
    public function setFacebook($facebook)
    {
        $this->facebook = $facebook;
    }


}
