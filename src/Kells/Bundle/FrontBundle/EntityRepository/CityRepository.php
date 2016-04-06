<?php
namespace Kells\Bundle\FrontBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository {
	
 public function findAll()
    {
    	
    return $query->getResult();
        return $this->findBy(array(), array('description' => 'ASC'));
    }
}