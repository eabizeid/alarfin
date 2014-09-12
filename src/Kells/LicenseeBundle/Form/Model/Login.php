<?php
// src/Kells/LicenseeBundle/Form/Model/Login.php
namespace Kells\LicenseeBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;


class Login
{
	/**
     * @Assert\NotBlank()
     */
	protected $cuit;
	/**
     * @Assert\NotBlank()
     */
    protected $password;
	
    

    public function getCuit()
    {
        return $this->cuit;
    }

    public function setCuit($cuit)
    {
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
}