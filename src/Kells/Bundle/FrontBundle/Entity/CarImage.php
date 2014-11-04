<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="carImages") 
 */
class CarImage {
	
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	
	 /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank()
     */
    private $imageName;

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
     * Set imageName
     *
     * @param string $imageName
     * @return CarImage
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * Get imageName
     *
     * @return string 
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * Set car
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Car $car
     * @return CarImage
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
