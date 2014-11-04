<?php
// src/Kells/LicenseeBundle/Form/Model/Login.php
namespace Kells\Bundle\FrontBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;


class Search
{
	/**
     * @Assert\NotBlank()
     */
	protected $pattern;
	
    
    public function getPattern()
    {
        return $this->pattern;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
    }
}