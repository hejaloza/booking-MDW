<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Habitacio;

class HabitacionControllerTest extends WebTestCase
{
    public function testCrearHabitacion()
    {
        $client = static::createClient();
        
        $data = array('tipo' => "1", 'hotel' => "2", 'estado' => "0", 'numero' => 'TestPruebaHabitacion');
        
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
    
    public function testEditarHabitacion()
    {
    	$client = static::createClient();
    	
    	$data = array('tipo' => "1", 'hotel' => "2", 'estado' => "0", 'numero' => 'TestPruebaHabitacion2');
    	$client->request('POST', '/editarHabitacion/3', $data);
    	
    	$crawler = $client->request('GET', '/listarHabitaciones');
    	
    	$response = $client->getResponse();
    	$cadenas = json_decode((string)$response->getContent());
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaHabitacion2")')->count());
    }
    
    public function testBorrarHabitacion()
    {
    	$client = static::createClient();
    	
    	$client->request('GET', '/borrarHabitacion/3');
    	$crawler = $client->request('GET', '/listarHabitaciones');
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertEquals(0, $crawler->filter('html:contains("TestPruebaHabitacio2")')->count());
    }
}
