<?php
// src/AppBundle/Repository/HabitacioRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use AppBundle\Entity\Habitacio;

class HabitacioRepository extends EntityRepository
{
	public function searchByZipCode($search, $from, $to, $horas)
	{
		return $this->getEntityManager()
		->createQuery(
				'SELECT ha1, ho1, t, c, ho1.precioHora * :horas as total   
				 FROM AppBundle:Habitacio ha1
            	 JOIN ha1.idHotel ho1
				 JOIN ha1.idTipo t
				 JOIN ho1.idCadena c
            	 WHERE ho1.codigoPostal = :zipCode
				 AND ha1.id NOT IN (
				
						 SELECT ha2.id FROM AppBundle:Reserva re2
		            	 JOIN re2.idHotel ho2
		            	 JOIN re2.idHabitacion ha2
		            	 WHERE ho2.codigoPostal = :zipCode
						 AND
							(
							  :from BETWEEN re2.fechaInicio AND re2.fechaFin
						 	  OR :to BETWEEN re2.fechaInicio AND re2.fechaFin
						 	  OR (
									:from <= re2.fechaInicio
									AND :to >= re2.fechaFin
								 )
							)
 					)'
				)
				->setParameter('zipCode', $search)
				->setParameter('from', $from)
				->setParameter('to', $to)
				->setParameter('horas', $horas)
				->getScalarResult();
				
	}
}