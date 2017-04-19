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
}
