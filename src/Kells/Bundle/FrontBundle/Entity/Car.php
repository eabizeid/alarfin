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
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank()
     */
	protected $description;
	/**
     * @ORM\ManyToOne(targetEntity="Trademark", inversedBy="trademarks")
     * @ORM\JoinColumn(name="trademark_id", referencedColumnName="id")
     **/
	protected $trademark;
	
	/**
     * @ORM\ManyToOne(targetEntity="Model",  inversedBy="models")
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
     * @ORM\ManyToOne(targetEntity="Fuel", inversedBy="fuels")
     * @ORM\JoinColumn(name="fuel_id", referencedColumnName="id")
     **/
	protected $fuel;
	
	/**
     * @ORM\ManyToOne(targetEntity="Year")
     * @ORM\JoinColumn(name="year_id", referencedColumnName="id")
     **/
	protected $year;
	
	/**
     * @ORM\ManyToOne(targetEntity="Direction")
     * @ORM\JoinColumn(name="direction_id", referencedColumnName="id")
     **/
	protected $direction;
	
	/**
     * @ORM\ManyToOne(targetEntity="Transmission", inversedBy="transmissions")
     * @ORM\JoinColumn(name="transmission_id", referencedColumnName="id")
     **/
	protected $transmission;
	
	/**
     * @ORM\ManyToOne(targetEntity="Province")
     * @ORM\JoinColumn(name="province_id", referencedColumnName="id")
     **/
	protected $province;
		
	/**
     * @ORM\ManyToOne(targetEntity="City")
     * @ORM\JoinColumn(name="city_id", referencedColumnName="id")
     **/
	protected $city;	
	

	/**
     * @ORM\ManyToMany(targetEntity="Feature")
     * @ORM\JoinTable(name="car_feature",
     *     joinColumns={@ORM\JoinColumn(name="car_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="feature_id", referencedColumnName="id")}
     * )
     */
	protected $features;
	
	/**
     * @ORM\OneToOne(targetEntity="ImageFile", cascade={"persist", "remove", "merge"})
     * @ORM\JoinColumn(name="mandatoryImage_id", referencedColumnName="id")
     **/
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
	
	
	
    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="cars")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     **/
	protected $user;
	
	
	 /**
     * @ORM\ManyToOne(targetEntity="Licensee", inversedBy="licensees")
     * @ORM\JoinColumn(name="licensee_id", referencedColumnName="id")
     **/
	protected $licensee;
	
	/**
	 * 
	 * @ORM\Column(type="date")
	 */
	protected $publishedDate;
	
	public function setId( $id ) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id; 
	}
	
	public function setFuel(\Kells\Bundle\FrontBundle\Entity\Fuel $fuel ) {
		$this->fuel = $fuel;
	}
	
	public function getFuel() {
		return $this->fuel;
	}
	
	public function getTrademark() {
		return $this->trademark;
	}
	
	public function setTrademark(\Kells\Bundle\FrontBundle\Entity\Trademark $trademark) {
		$this->trademark = $trademark;
	}
	
	public function getModel() {
		return $this->model;
	}
	
	public function setModel(\Kells\Bundle\FrontBundle\Entity\Model $model) {
		$this->model = $model;
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
        $images->setCar($this);

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

    /**
     * Set transmission
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Transmission $transmission
     * @return Car
     */
    public function setTransmission(\Kells\Bundle\FrontBundle\Entity\Transmission $transmission = null)
    {
        $this->transmission = $transmission;

        return $this;
    }

    /**
     * Get transmission
     *
     * @return \Kells\Bundle\FrontBundle\Entity\Transmission 
     */
    public function getTransmission()
    {
        return $this->transmission;
    }

    /**
     * Set user
     *
     * @param \Kells\Bundle\FrontBundle\Entity\User $user
     * @return Car
     */
    public function setUser(\Kells\Bundle\FrontBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Kells\Bundle\FrontBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set province
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Province $province
     * @return Car
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

    /**
     * Set city
     *
     * @param \Kells\Bundle\FrontBundle\Entity\City $city
     * @return Car
     */
    public function setCity(\Kells\Bundle\FrontBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Kells\Bundle\FrontBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set description
     *
     * @param integer $description
     * @return Car
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return integer 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set publishedDate
     *
     * @param \DateTime $publishedDate
     * @return Car
     */
    public function setPublishedDate($publishedDate)
    {
        $this->publishedDate = $publishedDate;

        return $this;
    }

    /**
     * Get publishedDate
     *
     * @return \DateTime 
     */
    public function getPublishedDate()
    {
        return $this->publishedDate;
    }
}
