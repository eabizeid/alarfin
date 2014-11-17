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
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     */
    private $description;

    
	/**
     * @ORM\ManyToOne(targetEntity="FeatureType")
     * @ORM\JoinColumn(name="featureType_id", referencedColumnName="id")
     **/
    private $featureType;


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
     * Set id
     *
     * @param \Sring $id
     * @return Feature
     */
    public function setId(\Sring $id)
    {
        $this->id = $id;

        return $this;
    }
}
