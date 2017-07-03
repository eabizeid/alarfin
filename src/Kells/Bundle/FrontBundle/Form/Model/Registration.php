<?php
// src/Kells/LicenseeBundle/Form/Model/Registration.php
namespace Kells\Bundle\FrontBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

use Kells\Bundle\FrontBundle\Entity\Licensee;

class Registration
{
    /**
     * @Assert\Type(type="Kells\Bundle\FrontBundle\Entity\Licensee")
     * @Assert\Valid()
     */
    protected $licensee;
    protected $image;

    /**
     * @Assert\NotBlank()
     * @Assert\True()
     */
    protected $termsAccepted;

    public function setLicensee(Licensee $licensee)
    {
        $this->licensee = $licensee;
    }

    public function getLicensee()
    {
        return $this->licensee;
    }

    
    public function getTermsAccepted()
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted($termsAccepted)
    {
        $this->termsAccepted = (Boolean) $termsAccepted;
    }

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


}