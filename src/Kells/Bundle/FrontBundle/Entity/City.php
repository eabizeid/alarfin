<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Kells\Bundle\FrontBundle\EntityRepository\CityRepository")
 * @ORM\Table(name="cities") 
 */
class City {
	
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	
	/**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank()
     */
	protected $description;
	
	/**
     * @ORM\ManyToOne(targetEntity="Province", inversedBy="province")
     * @ORM\JoinColumn(name="province_id", referencedColumnName="id")
     */
	protected $province;
	

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
     * @return City
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
     * Set province
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Province $province
     * @return City
     */
    public function setProvince(\Kells\Bundle\FrontBundle\Entity\Province $province = null)
    {
        $this->province = $province;

        return $this;
    }

    /**
     * Get province
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Province 
     */
    public function getProvince()
    {
        return $this->province;
    }
}
