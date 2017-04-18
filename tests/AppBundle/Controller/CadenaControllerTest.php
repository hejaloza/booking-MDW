<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CadenaControllerTest extends WebTestCase
{
    public function testCrearCadena()
    {
        $client = static::createClient();
        
        $cadenaprueba = new Cadena();
        $cadenaprueba->setNombre("TestPruebaCadena");
        $cadenaprueba->setResponsable("Responsable Prueba");
        $cadenaprueba->setLogotipo("Prueba");

        $em = $this->getDoctrine()->getManager();
        $em->persist($cadenaprueba);
        $em->flush();
        
        $crawler = $client->request('GET', '/listarCadenas');
        
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaCadena")')->count());
    }
    
    public function testListarCadena()
    {
    	$client = static::createClient();
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Cadena');
    	$cadenas = $repository->findAll()->count();
    	
    	$crawler = $client->request('GET', '/listarCadenas');
    	
    	$this->assertEquals(200, $cllient->getResponse()->getStatusCode());
    	$this->assertEquals($cadenas + 1, $crawler->filter('html:contains("</tr>")')->count());
    }
    
    public function testEditarCadena()
    {
    	$client = static::createClient();
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Cadena');
    	$cadena = $repository->findByNombre("TestPruebaCadena");	
    	
    	$cadena->setNombre("TestPruebaCadena2");
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($cadena);
    	$em->flush();
    	
    	$crawler = $client->request('GET', '/listarCadenas');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertGreaterThan(0, $crawler->filter('html:contains("TestPruebaCadena2")')->count());
    }
    
    public function testBorrarCadena()
    {
    	$client = static::createClient();
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Cadena');
    	$cadena = $repository->findByNombre("TestPruebaCadena2");
    	$em->remove($cadena);
    	$em->flush();
    	
    	$crawler = $client->request('GET', '/listarCadenas');
    	
    	$this->assertEquals(200, $client->getResponse()->getStatusCode());
    	$this->assertEquals(0, $crawler->filter('html:contains("TestPruebaCadena2")')->count());
    }
}
