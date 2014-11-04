<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="cars") 
 */
class Car {
	
	/**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;
	
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $title;
	
	/**
     * @ORM\OneToOne(targetEntity="Trademark")
     * @ORM\JoinColumn(name="trademark_id", referencedColumnName="id")
     **/
	protected $trademark;
	
	/**
     * @ORM\OneToOne(targetEntity="Model")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     **/
	protected $model;
	
	/**
     * @ORM\OneToOne(targetEntity="Version")
     * @ORM\JoinColumn(name="version_id", referencedColumnName="id")
     **/
	protected $version;

	/**
     * @ORM\Column(type="bigint")
     * @Assert\NotBlank()
     */
	protected $price;
	
	/**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     */
	protected $km;
	
	/**
     * @ORM\OneToOne(targetEntity="Fuel")
     * @ORM\JoinColumn(name="fuel_id", referencedColumnName="id")
     **/
	protected $fuel;
	
	/**
     * @ORM\OneToOne(targetEntity="Year")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     **/
	protected $year;
	
	/**
     * @ORM\OneToOne(targetEntity="Direction")
     * @ORM\JoinColumn(name="direction_id", referencedColumnName="id")
     **/
	protected $direction;
	
	/**
     * @ORM\OneToMany(targetEntity="Feature", mappedBy="car")
     */
	protected $features;
	
	/**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank()
     */
	protected $mandatoryImage;
	
	/**
     * @ORM\OneToMany(targetEntity="CarImage", mappedBy="car", cascade={"persist", "remove", "merge"})
     */
	protected $images;
	
	
	/**
     * @ORM\Column(type="string", length=50)
     * @Assert\NotBlank()
     */
	protected $color;
	
	/**
     * @ORM\Column(type="string", length=10)
     */
	protected $status = "PUBLISHED";
	
	public function setId( $id ) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id; 
	}
	
	public function setFuel( $fuel ) {
		$this->fuel = $fuel;
	}
	
	public function getFuel() {
		return $this->fuel;
	}
	
	public function getTrademark() {
		return $this->trademark;
	}
	
	public function setTrademark( $trademark) {
		$this->trademark;
	}
	
	public function getModel() {
		return $this->model;
	}
	
	public function setModel( $model) {
		$this->model;
	}
	
	public function getVersion() {
		return $this->version;
	}
	
	public function setVersion( $version) {
		$this->version;
	}
	
	public function setTitle( $title ) {
		$this->title = $title;
	}
	
	public function getTitle() {
		return $this->title;
	}
	
	public function setPrice( $price ) {
		$this->price = $price;
	}
	
	public function getPrice() {
		return $this->price;
	}
	
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->features = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set km
     *
     * @param integer $km
     * @return Car
     */
    public function setKm($km)
    {
        $this->km = $km;

        return $this;
    }

    /**
     * Get km
     *
     * @return integer 
     */
    public function getKm()
    {
        return $this->km;
    }

    /**
     * Set year
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Year $year
     * @return Car
     */
    public function setYear(\Kells\Bundle\FrontBundle\Entity\Year $year = null)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Year 
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set direction
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Direction $direction
     * @return Car
     */
    public function setDirection(\Kells\Bundle\FrontBundle\Entity\Direction $direction = null)
    {
        $this->direction = $direction;

        return $this;
    }

    /**
     * Get direction
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Direction 
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Add features
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Feature $features
     * @return Car
     */
    public function addFeature(\Kells\Bundle\FrontBundle\Entity\Feature $features)
    {
        $this->features[] = $features;

        return $this;
    }

    /**
     * Remove features
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Feature $features
     */
    public function removeFeature(\Kells\Bundle\FrontBundle\Entity\Feature $features)
    {
        $this->features->removeElement($features);
    }

    /**
     * Get features
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeatures()
    {
        return $this->features;
    }

    /**
     * Set mandatoryImage
     *
     * @param string $mandatoryImage
     * @return Car
     */
    public function setMandatoryImage($mandatoryImage)
    {
        $this->mandatoryImage = $mandatoryImage;

        return $this;
    }

    /**
     * Get mandatoryImage
     *
     * @return string 
     */
    public function getMandatoryImage()
    {
        return $this->mandatoryImage;
    }

    /**
     * Add images
     *
     * @param \Kells\Bundle\FrontBundle\Entity\CarImage $images
     * @return Car
     */
    public function addImage(\Kells\Bundle\FrontBundle\Entity\CarImage $images)
    {
        $this->images[] = $images;

        return $this;
    }

    /**
     * Remove images
     *
     * @param \Kells\Bundle\FrontBundle\Entity\CarImage $images
     */
    public function removeImage(\Kells\Bundle\FrontBundle\Entity\CarImage $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return Car
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Car
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }
}
