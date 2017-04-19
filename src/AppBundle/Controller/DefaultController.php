<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Habitacion;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     * @Route("/listar", name="listar")
     */
    public function listarAction()
    {
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Habitacion');
    	$habitaciones = $repository->findAll();	
    	return $this->render('AppBundle:Default:listar_habitaciones.html.twig', array('habitaciones' => $habitaciones));
    	
    }
    
    /**
     * @Route("/crear", name="crearGet")
     * @Method({"GET"})
     */
    public function formCrearAction()
    {
    	
    	return $this->render('AppBundle:Default:crear_habitacion.html.twig', array(
    			'errors'		   => []	
    	));
    	
    }
    
    
    /**
     * @Route("/crear", name="crearPost")
     * @Method({"POST"})
     */
    public function crearAction(Request $request)
    {
 		$nombre=$request->request->get('nombre');
 		$descripcion=$request->request->get('descripcion');
 		
    	$habitacion = new Habitacion();
    	$habitacion->setNombre($nombre);
    	$habitacion->setDescripcion($descripcion);
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($habitacion);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Habitacion Creada');
    	return $this->redirectToRoute('listar');
    	
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
     * @Route("/borrar/{id}", name="borrar")
     */
    public function borrarAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository=$em->getRepository('AppBundle:Habitacion');
    	$habitacion = $repository->find($id);
    	$em->remove($habitacion);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Habitacion borrada');
    	return $this->redirectToRoute('listar');
    }
    
    /**
     * @Route("/search", name="searchRoom")
     * @Method({"POST"})
     */
    public function searchRoom(Request $request)
    {
    	$em = $this->getDoctrine()->getManager();

    	$em = $this->getDoctrine()->getManager();
    	
    	$habitaciones = $em->getRepository('AppBundle:Habitacion')
    	->findSearch($request->request->get('search'), $request->request->get('search'), $request->request->get('search'));
    	
    	return $habitaciones;
    }
    
}
