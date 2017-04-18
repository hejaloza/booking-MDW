<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Reserva;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class ReservaController extends Controller
{
    
    /**
     * @Route("/listarReservas", name="listarReservas")
     */
    public function listarReservasAction()
    {
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Reserva');
    	$reservas = $repository->findAll();	
    	return $this->render('AppBundle:Reserva:listar_reservas.html.twig', array('reservas' => $reservas));
    	
    }
    
    
    /**
     * @Route("/editarGet/{id}", name="editarGet")
     * @Method({"GET"})
     */
    public function editarGetAction($id)
    {
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Habitacion');
    	$habitacion = $repository->find($id);	
    	return $this->render('AppBundle:Default:habitacion.html.twig', array('habitacion' => $habitacion, 'errors' => []));
    	
    }
    
    /**
     * @Route("/editarPost/{id}", name="editarPost")
     * @Method({"POST"})
     */
    public function editarPostAction($id,Request $request)
    {
    	$nombre=$request->request->get('nombre');
    	$descripcion=$request->request->get('descripcion');
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Habitacion');
    	$habitacion = $repository->find($id);	

    	$habitacion->setNombre($nombre);
    	$habitacion->setDescripcion($descripcion);
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($habitacion);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Habitacion Modificada');
    	return $this->redirectToRoute('listar');
    	
    	
    	
    }
    
    
    /**
     * @Route("/cancelarReserva/{id}", name="cancelarReserva")
     */
    public function cancelarReservaAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository=$em->getRepository('AppBundle:Reserva');
    	$reserva = $repository->find($id);
    	$reserva->setEstado("3");
    	$em->persist($reserva);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Reserva cancelada');
    	return $this->redirectToRoute('listarReservas');
    }
    
     
    
}
