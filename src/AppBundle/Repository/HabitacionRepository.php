<?php
// src/AppBundle/Repository/HabitacionRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class HabitacionRepository extends EntityRepository
{
	public function findSearch()
	{
		return $this->getEntityManager()
		->createQuery(
				'SELECT p FROM AppBundle:Habitacion p ORDER BY p.id ASC'
				)
				->getResult();
	}
}