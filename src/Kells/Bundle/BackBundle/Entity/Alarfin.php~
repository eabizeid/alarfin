<?php
namespace Kells\Bundle\BackBundle\Entity;

use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="alarfines") 
 */
class Alarfin implements UserInterface {
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
     * @Assert\NotBlank()
     */
	protected $password;
	
	/**
     * @ORM\ManyToMany(targetEntity="\Kells\Bundle\FrontBundle\Entity\Rol")
     * @ORM\JoinTable(name="alarfin_rol",
     *     joinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="rol_id", referencedColumnName="id")}
     * )
     */
    protected $roles;
    
    
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
    
    
 /**
     * Constructor
     */
    public function __construct()
    {
        $this->roles = new \Doctrine\Common\Collections\ArrayCollection();
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
        return array('ROLE_ALARFIN');
    }

public function getSalt()
    {
        return "";
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return User
     */
    public function setSalt($salt)
    {

        return $this;
    }
    
     public function eraseCredentials()
    {
    }
}
