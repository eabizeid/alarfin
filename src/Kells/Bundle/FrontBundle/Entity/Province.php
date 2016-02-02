<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Kells\Bundle\FrontBundle\EntityRepository\ProvinceRepository")
 * @ORM\Table(name="provinces") 
 */
class Province {
	
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
     * @ORM\OneToMany(targetEntity="City", mappedBy="province")
     * @ORM\OrderBy({"description" = "ASC"})
     */
	protected $cities;
	
	
 	public function __construct() {
        $this->versions = new ArrayCollection();
    }
	
	public function setId( $id ) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id; 
	}
	
	public function setDescription( $description ) {
		$this->description = $description;
	}
	
	public function getDescription () {
		return $this->description;
	}
	

	
	public function getCities() {
		return $this->cities;
	}
	
	public function setCities( $cities) {
		$this->cities  = $cities;
	}


    /**
     * Add cities
     *
     * @param \Kells\Bundle\FrontBundle\Entity\City $cities
     * @return Province
     */
    public function addCity(\Kells\Bundle\FrontBundle\Entity\City $cities)
    {
        $this->cities[] = $cities;

        return $this;
    }

    /**
     * Remove cities
     *
     * @param \Kells\Bundle\FrontBundle\Entity\City $cities
     */
    public function removeCity(\Kells\Bundle\FrontBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }
}
