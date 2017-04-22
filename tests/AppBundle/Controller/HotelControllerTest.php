<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HotelControllerTest extends WebTestCase
{
    public function testCrearHotel()
    {
    	$client = static::createClient();
        
    	$data = array('nombre' => "TestPruebaHotel", 'direccion' => "Direccion Prueba", 'responsable' => "Responsable Prueba", 'id_cadena' => "1", 
        'precio_hora' => "150", 'codigo_postal' => "28008", 'min_horas' => "2");
        
        $client->request('POST', '/crearHotel', $data);
        
        $crawler = $client->request('GET', '/listarHoteles');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaHotel")')->count());
        $client = static::createClient();

    }
    
   
    public function testListarHoteles()
    {
    	$client = static::createClient();
    	
    	$crawler = $client->request('GET', '/listarHoteles');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaHotel")')->count());

    }
    
    
    public function testEditarHotel()
    {
    	$client = static::createClient();
	
    	$data = array('nombre' => "TestPruebaHotel2", 'direccion' => "Direccion Prueba", 'responsable' => "Responsable Prueba", 'id_cadena' => "2", 
        'precio_hora' => "150", 'codigo_postal' => "28008", 'min_horas' => "2");
    	
    	$crawler = $client->request('GET', '/listarHoteles');
    	
    	$response = $client->getResponse();
    	$cadenas = json_decode((string)$response->getContent());
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaHotel2")')->count());
    
    }
    
    public function testBorrarHotel()
    {
    	$client = static::createClient();
    	
    	$client->request('GET', '/borrarHotel/2');
    	$crawler = $client->request('GET', '/listarHoteles');
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertEquals(0, $crawler->filter('html:contains("TestPruebaCadena2")')->count());
    }
}