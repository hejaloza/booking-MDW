<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Habitacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
    
    /**
     * @Route("/searchByZipCode/{search}/{from}/{to}", name="searchRoomZipCode")
     * @Method({"GET"})
     */
    public function searchRoomByZipCode($search, $from, $to)
    {    	
    	
    	$from = new DateTime($from);
    	$to = new DateTime($to);
    	
    	$calculo_fecha = $from->diff($to);
    	$horas = $calculo_fecha->h;
    	
    	date_sub($from, date_interval_create_from_date_string('2 hours'));
    	
    	$habitacioRepository = $this->getDoctrine()->getRepository('AppBundle:Habitacio');
    	$habitaciones = $habitacioRepository->searchByZipCode($search, $from, $to, $horas);
    	
    	return new Response (json_encode(array ('habitaciones' => $habitaciones)) );
    }
    
}
