<?php
namespace Kells\Bundle\FrontBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class TrademarkRepository extends EntityRepository {
	
 public function findAll()
    {
        return $this->findBy(array(), array('description' => 'ASC'));
    }
}