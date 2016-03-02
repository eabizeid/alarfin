<?php
namespace Kells\Bundle\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="Kells\Bundle\FrontBundle\EntityRepository\ModelRepository")
 * @ORM\Table(name="models") 
 */
class Model {
	
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
     * @ORM\ManyToOne(targetEntity="Trademark", inversedBy="trademarks")
     * @ORM\JoinColumn(name="trademark_id", referencedColumnName="id")
     */
	protected $trademark;
	
	/**
     * @ORM\OneToMany(targetEntity="Version", mappedBy="model")
     */
	protected $versions;
	
	
 	public function __construct() {
        
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
	
	public function getTrademark() {
		return $this->trademark;
	}
	
	public function setTrademark( $trademark) {
		$this->trademark;
	}
	
	public function getVersions() {
		return $this->versions;
	}
	
	public function setVersions( $versions) {
		$this->versions;
	}

    /**
     * Add versions
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Version $versions
     * @return Model
     */
    public function addVersion(\Kells\Bundle\FrontBundle\Entity\Version $versions)
    {
        $this->versions[] = $versions;

        return $this;
    }

    /**
     * Remove versions
     *
     * @param \Kells\Bundle\FrontBundle\Entity\Version $versions
     */
    public function removeVersion(\Kells\Bundle\FrontBundle\Entity\Version $versions)
    {
        $this->versions->removeElement($versions);
    }
}
