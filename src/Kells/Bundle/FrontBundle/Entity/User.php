<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields={"mail"}, message="Este mail ya se encuentra registrado"), 
 * @ORM\Table(name="users") 
 */
class User implements UserInterface {
	
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
		/**
     * @ORM\Column(type="string", length=60)
     */
	protected $firstName;
		/**
     * @ORM\Column(type="string", length=60)
     */
	protected $lastName;
		/**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     */
	protected $mail;
		/**
     * @ORM\Column(type="string", length=60)
     */
	protected $telephone;
	
	/**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     */
	protected $password;
	
	  /**
     * @ORM\Column(type="string", length=255)
     */
    protected $token;
	
    /**
     * @ORM\Column(type="boolean")
     */
	protected $status;
	
	/**
     * @ORM\ManyToMany(targetEntity="Rol")
     * @ORM\JoinTable(name="usuario_rol",
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
     * @ORM\OneToMany(targetEntity="Car", mappedBy="user", cascade="remove")
     **/
    protected $cars;

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
     * Set firstName
     *
     * @param string $firstName
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return User
     */
    public function setMail($mail)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getMail()
    {
        return $this->mail;
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

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Get cuit
     *
     * @return string 
     */
    public function getCuit()
    {
        return $this->cuit;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return User
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

    public function getToken()
    {
        return $this->token;
    }

    public function setToken($token)
    {
        $this->token = $token;
    }
    
    
	public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
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
        return array('ROLE_USER');
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
    
    public function getName() {
    	return $this->firstName." ".$this->lastName;
    }
}
