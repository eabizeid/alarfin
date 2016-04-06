<?php
namespace Kells\Bundle\FrontBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class LicenseeRepository extends EntityRepository {
	
 public function findAll() {
	
      return $this->createQueryBuilder('l')
        ->leftjoin('l.city','c')
        ->addOrderBy('c.description', 'ASC')
        ->addOrderBy('l.fantasyName', 'ASC')
        ->getQuery() 
        ->getResult();
 }
}