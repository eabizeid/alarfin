<?php
// src/Kells/LicenseeBundle/Form/Model/Registration.php
namespace Kells\Bundle\FrontBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Kells\Bundle\FrontBundle\Entity\User;

class UserRegistration
{
    /**
     * @Assert\Type(type="Kells\Bundle\FrontBundle\Entity\User")
     * @Assert\Valid()
     */
    protected $user;
    

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setUser(User $user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    
    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (Boolean) $termsAccepted;
    }
    
}