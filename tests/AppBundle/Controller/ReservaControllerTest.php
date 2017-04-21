<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservaControllerTest extends WebTestCase
{
    public function testListarReservas()
    {
    	$client = static::createClient();
    	
    	$crawler = $client->request('GET', '/listarReservas');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains("pepe")')->count());
    }
    
    public function testConsultarCliente()
    {
    	$client = static::createClient();
    	
    	$crawler = $client->request('GET', '/cliente/jahir@gmail.com');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	
    }
    
    public function testCrearReserva()
    {
    	$client = static::createClient();
    	
    	$data = array('id_habitacion' => 2, 'id_cliente' => 1, 'id_hotel' => 4,'precio'=>400,'fecha_entrada'=>"2017-01-01 00:00:00",'fecha_salida'=>"2017-01-01 00:00:00");
    	
    	$client->request('POST', '/reservar', $data);
    	
    	$crawler = $client->request('GET', '/listarReservas');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains(400)')->count());
    }
    
    public function testEditarReserva()
    {
    	$client = static::createClient();
    	
    	$data = array('id_reserva' => 5, 'fecha_entrada' => "2017-02-01 00:00:02", 'fecha_salida' => "2017-02-01 01:00:02");
    	$client->request('POST', '/modificarReservaPost', $data);
    	
    	$crawler = $client->request('GET', '/listarReservas');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains("2017-02-01 00:00:02")')->count());
    }
    
    
}
