<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Hotel;
use AppBundle\Entity\Cadena;

class HotelController extends Controller
{
	/**
	 * @Route("/listarHoteles", name="listarHoteles")
	 */
	public function listarHotelesAction()
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Hotel');
		$hoteles = $repository->findAll();
		return $this->render('AppBundle:Hotel:listar_hoteles.html.twig', array('hoteles' => $hoteles));
	}
	
    /**
     * @Route("/crearHotel", name="crearHotel")
     * @Method({"GET"})
     */
    public function formCrearHotelAction()
    {
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Cadena');
    	$cadenas = $repository->findAll();
    	return $this->render('AppBundle:Hotel:crear_hotel.html.twig',
    			array('cadenas' => $cadenas, 'errors' => [])
    			);
    }
    
    /**
     * @Route("/crearHotel", name="crearHotelPost")
     * @Method({"POST"})
     */
    public function crearHotelAction(Request $request)
    {
    	$nombre=$request->request->get('nombre');
    	$responsable=$request->request->get('responsable');
    	$direccion=$request->request->get('direccion');
    	$id_cadena=$request->request->get('id_cadena');
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Cadena');
    	$cadena = $repository->find($id_cadena);
    	$precio_hora=$request->request->get('precio_hora');
    	$codigo_postal=$request->request->get('codigo_postal');
    	$min_horas=$request->request->get('min_horas');

    	$hotel = new Hotel();
    	$hotel->setNombre($nombre);
    	$hotel->setResponsable($responsable);
    	$hotel->setDireccion($direccion);
    	$hotel->setIdCadena($cadena);
    	$hotel->setPrecioHora($precio_hora);
    	$hotel->setCodigoPostal($codigo_postal);
    	$hotel->setMinHoras($min_horas);

    	$em = $this->getDoctrine()->getManager();
    	$em->persist($hotel);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Hotel Creado');
    	return $this->redirectToRoute('listarHoteles');	
    }
    
    
    /**
     * @Route("/editarHotel/{id}", name="editarHotelGet")
     * @Method({"GET"})
     */
    public function editarGetAction($id)
    {
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Hotel');
    	$hotel = $repository->find($id);	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Cadena');
    	$cadenas = $repository->findAll();
    	return $this->render('AppBundle:Hotel:editar_hotel.html.twig', array('hotel' => $hotel, 'cadenas' => $cadenas, 'errors' => []));
    	
    }
    
    /**
     * @Route("/editarHotel/{id}", name="editarHotelPost")
     * @Method({"POST"})
     */
    public function editarPostAction($id,Request $request)
    {
    	$nombre=$request->request->get('nombre');
    	$responsable=$request->request->get('responsable');
    	$direccion=$request->request->get('direccion');
    	$id_cadena=$request->request->get('id_cadena');
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Cadena');
    	$cadena = $repository->find($id_cadena);
    	$precio_hora=$request->request->get('precio_hora');
    	$codigo_postal=$request->request->get('codigo_postal');
    	$min_horas=$request->request->get('min_horas');
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Hotel');
    	$hotel = $repository->find($id);

    	$hotel->setNombre($nombre);
    	$hotel->setResponsable($responsable);
    	$hotel->setDireccion($direccion);
    	$hotel->setIdCadena($cadena);
    	$hotel->setPrecioHora($precio_hora);
    	$hotel->setCodigoPostal($codigo_postal);
    	$hotel->setMinHoras($min_horas);
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($hotel);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Hotel Modificado');
    	return $this->redirectToRoute('listarHoteles');

    }

    /**
     * @Route("/borrarHotel/{id}", name="borrarHotel")
     */
    public function borrarHotelAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository=$em->getRepository('AppBundle:Hotel');
    	$hotel = $repository->find($id);
    	$em->remove($hotel);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Hotel borrado');
    	return $this->redirectToRoute('listarHoteles');
    }

}
