<?php
namespace Kells\Bundle\FrontBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class LicenseeRepository extends EntityRepository {
	
 public function findAll() {
	
      return $this->createQueryBuilder()
        ->select('l')
        ->join('l.City', 'c')
        ->addOrderBy('c.description', 'ASC')
        ->getQuery() 
        ->getResult();
 }
}