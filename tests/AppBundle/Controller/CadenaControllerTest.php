<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\Cadena;

class CadenaControllerTest extends WebTestCase
{
    public function testCrearCadena()
    {
        $client = static::createClient();
        
        $data = array('nombre' => "TestPruebaCadena", 'responsable' => "Responsable Prueba", 'logotipo' => "Logotipo Prueba");
        
        $client->request('POST', '/crearCadena', $data);
        
        $crawler = $client->request('GET', '/listarCadenas');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaCadena")')->count());
    }

    public function testListarCadena()
    {
    	$client = static::createClient();
    	
    	$crawler = $client->request('GET', '/listarCadenas');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaCadena")')->count());
    }
    
    public function testEditarCadena()
    {
    	$client = static::createClient();
	
    	$data = array('nombre' => "TestPruebaCadena2", 'responsable' => "Responsable Prueba", 'logotipo' => "Logotipo Prueba");
    	$client->request('POST', '/editarCadena/1', $data);
    	
    	$crawler = $client->request('GET', '/listarCadenas');
    	
    	$response = $client->getResponse();
    	$cadenas = json_decode((string)$response->getContent());
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaCadena2")')->count());
    }
    
    public function testBorrarCadena()
    {
    	$client = static::createClient();
    	
    	$client->request('GET', '/borrarCadena/1');
    	$crawler = $client->request('GET', '/listarCadenas');
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertEquals(0, $crawler->filter('html:contains("TestPruebaCadena2")')->count());
    }
}