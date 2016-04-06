<?php
namespace Kells\Bundle\FrontBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class LicenseeRepository extends EntityRepository {
	
 public function findAll() {
	
      return $this->createQueryBuilder('l')
        ->join('l.city','c')
        ->addOrderBy('c.description', 'ASC')
        ->getQuery() 
        ->getResult();
 }
}