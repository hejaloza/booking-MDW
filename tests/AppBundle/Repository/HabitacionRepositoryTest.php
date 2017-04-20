<?php

// tests/AppBundle/Repository/ProductRepositoryTest.php
namespace Tests\AppBundle\Repository;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HabitacionRepositoryTest extends KernelTestCase
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	private $em;
	
	/**
	 * {@inheritDoc}
	 */
	protected function setUp()
	{
		self::bootKernel();
		
		$this->em = static::$kernel->getContainer()
		->get('doctrine')
		->getManager();
	}
	
	public function testsearchByZipCode()
	{
		$habitacioRepository = $this->em->getRepository('AppBundle:Habitacio');
		$habitaciones = $habitacioRepository->searchByZipCode(28009, '2017-04-27 23:59:59', '2017-04-28 23:59:59');
		
		$this->assertCount(0, $habitaciones);
	}
	
	/**
	 * {@inheritDoc}
	 */
	protected function tearDown()
	{
		parent::tearDown();
		
		$this->em->close();
		$this->em = null; // avoid memory leaks
	}
	
}