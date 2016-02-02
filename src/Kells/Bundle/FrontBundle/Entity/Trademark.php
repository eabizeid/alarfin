<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Kells\Bundle\FrontBundle\EntityRepository\TrademarkRepository")
 * @ORM\Table(name="trademarks") 
 */
class Trademark {
	
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
     * @ORM\OneToMany(targetEntity="Model", mappedBy="trademark")
     * @ORM\OrderBy({"description" = "ASC"})
     */
	protected $models;
	
	
 	public function __construct() {
        $this->models = new ArrayCollection();
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
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setModels($models) {
		$this->models = $models;
	}
	
	public function getModels() {
		return $this->models;
	}

    /**
     * Add models
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Model $models
     * @return Trademark
     */
    public function addModel(\Kells\Bundle\FrontBundle\Entity\Model $models)
    {
        $this->models[] = $models;

        return $this;
    }

    /**
     * Remove models
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Model $models
     */
    public function removeModel(\Kells\Bundle\FrontBundle\Entity\Model $models)
    {
        $this->models->removeElement($models);
    }
}
