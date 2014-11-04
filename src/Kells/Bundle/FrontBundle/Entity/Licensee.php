<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity
 * @UniqueEntity(fields="cuit", message="Cuit se encuentra registrado")
 * @ORM\Table(name="licensees") 
 */
class Licensee {
	
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
    protected $plainPassword;
    
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
	

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
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
	
}
