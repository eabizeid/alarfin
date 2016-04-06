<?php
namespace Kells\Bundle\FrontBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class LicenseeRepository extends EntityRepository {
	
 public function findAll() {
	
      return $this->createQueryBuilder('l')
        ->leftJoin('l.city','c')
        ->orderBy('c.description', 'asc')
        ->orderBy('l.fantasyName', 'asc')
        ->getQuery() 
        ->getResult();
 }
}