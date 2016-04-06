<?php
namespace Kells\Bundle\FrontBundle\EntityRepository;

use Doctrine\ORM\EntityRepository;

class LicenseeRepository extends EntityRepository {
	
 public function findAll()
    {
	
    $em = $this->getEntityManager();

    $query = $em->createQuery('
        SELECT *
        FROM KellsFrontBundle:Licensee l
        ORDER BY l.fantasyName ASC, l.city.description  ASC
    ');
    return $query->getResult();
    }
}