<?php

namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="features") 
 */
class Feature
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     */
    private $description;

    
	/**
     * @ORM\OneToOne(targetEntity="FeatureType")
     * @ORM\JoinColumn(name="featureType_id", referencedColumnName="id")
     **/
    private $featureType;

     /**
     * @ORM\ManyToOne(targetEntity="Car", inversedBy="cars")
     * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
     */
	protected $car;

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
     * Set description
     *
     * @param string $description
     * @return Feature
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set featureType
     *
     * @param \Kells\Bundle\FrontBundle\Entity\FeatureType $featureType
     * @return Feature
     */
    public function setFeatureType(\Kells\Bundle\FrontBundle\Entity\FeatureType $featureType = null)
    {
        $this->featureType = $featureType;

        return $this;
    }

    /**
     * Get featureType
     *
     * @return \Kells\Bundle\FrontBundle\Entity\FeatureType 
     */
    public function getFeatureType()
    {
        return $this->featureType;
    }

    /**
     * Set car
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Car $car
     * @return Feature
     */
    public function setCar(\Kells\Bundle\FrontBundle\Entity\Car $car = null)
    {
        $this->car = $car;

        return $this;
    }

    /**
     * Get car
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Car 
     */
    public function getCar()
    {
        return $this->car;
    }
}
