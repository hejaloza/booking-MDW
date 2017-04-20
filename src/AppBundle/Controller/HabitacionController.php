<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Habitacio;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HabitacionController extends Controller
{
      
    /**
     * @Route("/listarHabitaciones", name="listarHabitaciones")
     */
    public function listarHabitacionAction()
    {
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Habitacio');
    	$habitaciones = $repository->findAll();	
    	return $this->render('AppBundle:Habitacion:listar_habitaciones.html.twig', array('habitaciones' => $habitaciones));
    	
    }
    
    /**
     * @Route("/crearHabitacion", name="crearHabitacionGet")
     * @Method({"GET"})
     */
    public function formCrearHabitacionAction()
    {
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Hotel');
    	$hoteles = $repository->findAll();
    	$repository = $this->getDoctrine()->getRepository('AppBundle:TipoHabitacion');
    	$tipos_habitacion = $repository->findAll();
    	return $this->render('AppBundle:Habitacion:crear_habitacion.html.twig', array('hoteles' => $hoteles,
    			'tipos' => $tipos_habitacion,
    			'errors'		   => []	
    	));
    	
    }
    
    
    /**
     * @Route("/crearHabitacion", name="crearHabitacionPost")
     * @Method({"POST"})
     */
    public function crearHabitacionAction(Request $request)
    {
 		$id_tipo=$request->request->get('tipo');
 		$id_hotel=$request->request->get('hotel');
 		$repository = $this->getDoctrine()->getRepository('AppBundle:TipoHabitacion');
 		$tipo = $repository->find($id_tipo);
 		$repository = $this->getDoctrine()->getRepository('AppBundle:Hotel');
 		$hotel = $repository->find($id_hotel);
 		$estado = $request->request->get('estado');
 		$numero = $request->request->get('numero');
 		
    	$habitacion = new Habitacio();
    	$habitacion->setIdTipo($tipo);
    	$habitacion->setIdHotel($hotel);
    	$habitacion->setEstado($estado);
    	$habitacion->setNumero($numero);
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($habitacion);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Habitacion Creada');
    	return $this->redirectToRoute('listarHabitaciones');
    	
    }
    
    /**
     * @Route("/editarHabitacionGet/{id}", name="editarHabitacionGet")
     * @Method({"GET"})
     */
    public function editarGetAction($id)
    {
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Habitacio');
    	$habitacion = $repository->find($id);	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Hotel');
    	$hoteles = $repository->findAll();
    	$repository = $this->getDoctrine()->getRepository('AppBundle:TipoHabitacion');
    	$tipos_habitacion = $repository->findAll();
    	return $this->render('AppBundle:Habitacion:editar_habitacion.html.twig', array('habitacion' => $habitacion, 'hoteles' => $hoteles,
    			'tipos' => $tipos_habitacion, 'errors' => []));
    	
    }
    
    /**
     * @Route("/editarHabitacionPost/{id}", name="editarHabitacionPost")
     * @Method({"POST"})
     */
    public function editarPostAction($id,Request $request)
    {
    	$id_tipo=$request->request->get('tipo');
    	$id_hotel=$request->request->get('hotel');
    	$repository = $this->getDoctrine()->getRepository('AppBundle:TipoHabitacion');
    	$tipo = $repository->find($id_tipo);
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Hotel');
    	$hotel = $repository->find($id_hotel);    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Habitacio');
    	$habitacion = $repository->find($id);
    	$estado = $request->request->get('estado');
    	$numero = $request->request->get('numero');

    	$habitacion->setIdTipo($tipo);
    	$habitacion->setIdHotel($hotel);
    	$habitacion->setEstado($estado);
    	$habitacion->setNumero($numero);
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($habitacion);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Habitacion Modificada');
    	return $this->redirectToRoute('listarHabitaciones');

    }
    
    
    /**
     * @Route("/borrarHabitacion/{id}", name="borrarHabitacion")
     */
    public function borrarHabitacionAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository=$em->getRepository('AppBundle:Habitacio');
    	$habitacion = $repository->find($id);
    	$em->remove($habitacion);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Habitacion borrada');
    	return $this->redirectToRoute('listarHabitaciones');
    }
    
     
    
}
