<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservaControllerTest extends WebTestCase
{
    public function testListarReservas()
    {
    	$client = static::createClient();
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Reserva');
    	$reservas = $repository->findAll()->count();
    	
    	$crawler = $client->request('GET', '/listarReservas');
    	
    	$this->assertEquals(200, $cllient->getResponse()->getStatusCode());
    	$this->assertEquals($reservas + 1, $crawler->filter('html:contains("</tr>")')->count());
    }
}
