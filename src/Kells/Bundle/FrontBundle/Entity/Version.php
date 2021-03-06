<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="versions") 
 */
class Version {
	
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
     * @ORM\ManyToOne(targetEntity="Model", inversedBy="models")
     * @ORM\JoinColumn(name="model_id", referencedColumnName="id")
     */
	protected $model;
	
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
	
	public function getModel() {
		$this->model;
	}
	
	public function setModel( $model ) {
		$this->model = $model;
	}
}
