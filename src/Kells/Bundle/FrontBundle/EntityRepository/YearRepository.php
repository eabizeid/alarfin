<?php
namespace Kells\Bundle\FrontBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class YearRepository extends EntityRepository {
	
 public function findAll()
    {
        return $this->findBy(array(), array('description' => 'DESC'));
    }
}