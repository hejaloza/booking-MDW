<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Habitacio;

class HabitacionControllerTest extends WebTestCase
{
    public function testCrearHabitacion()
    {
        $client = static::createClient();
        
        $data = array('tipo' => "1", 'hotel' => "1", 'estado' => "0", 'numero' => 'TestPruebaHabitacion');
        
        $client->request('POST', '/crearHabitacion', $data);
        
        
        $crawler = $client->request('GET', '/listarHabitaciones');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaHabitacion")')->count());
    }
    
    public function testListarHabitacion()
    {
    	$client = static::createClient();
    	
    	$crawler = $client->request('GET', '/listarHabitaciones');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaHabitacion")')->count());
    }
    /*
    public function testEditarHabitacion()
    {
    	$client = static::createClient();
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Habitacion');
    	$habitacion = $repository->findByNumero("TestPruebaHabitacion");
    	
    	$habitacion->setNumero("TestPruebaHabitacion2");
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($habitacion);
    	$em->flush();
    	
    	$crawler = $client->request('GET', '/listarHabitaciones');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaHabitacion2")')->count());
    }
    
    public function testBorrarHabitacion()
    {
    	$client = static::createClient();
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Habitacion');
    	$habitacion = $repository->findByNumero("TestPruebaHabitacion2");
    	$em->remove($habitacion);
    	$em->flush();
    	
    	$crawler = $client->request('GET', '/listarHabitaciones');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertEquals(0, $crawler->filter('html:contains("TestPruebaHabitacion2")')->count());
    }*/
}
