<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Entity\Cadena;

class CadenaController extends Controller
{
	/**
	 * @Route("/listarCadenas", name="listarCadenas")
	 */
	public function listarCadenasAction()
	{
		$repository = $this->getDoctrine()->getRepository('AppBundle:Cadena');
		$cadenas = $repository->findAll();
		return $this->render('AppBundle:Cadena:listar_cadenas.html.twig', array('cadenas' => $cadenas));
	}
	
    /**
     * @Route("/crearCadena", name="crearCadena")
     * @Method({"GET"})
     */
    public function formCrearCadenaAction()
    {
    	
    	return $this->render('AppBundle:Cadena:crear_cadena.html.twig', 
    			array('errors' => [])
    			);
    }
    
    /**
     * @Route("/crearCadena", name="crearCadenaPost")
     * @Method({"POST"})
     */
    public function crearCadenaAction(Request $request)
    {
    	$nombre=$request->request->get('nombre');
    	$responsable=$request->request->get('responsable');
    	$logotipo=$request->request->get('logotipo');
    	
    	$cadena = new Cadena();
    	$cadena->setNombre($nombre);
    	$cadena->setResponsable($responsable);
    	$cadena->setLogotipo($logotipo);
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($cadena);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Cadena Creada');
    	return $this->redirectToRoute('listarCadenas');	
    }
    
    
    /**
     * @Route("/editarCadena/{id}", name="editarCadenaGet")
     * @Method({"GET"})
     */
    public function editarGetAction($id)
    {
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Cadena');
    	$cadena = $repository->find($id);	
    	return $this->render('AppBundle:Cadena:editar_cadena.html.twig', array('cadena' => $cadena, 'errors' => []));
    	
    }
    
    /**
     * @Route("/editarCadena/{id}", name="editarCadenaPost")
     * @Method({"POST"})
     */
    public function editarPostAction($id,Request $request)
    {
    	$nombre=$request->request->get('nombre');
    	$responsable=$request->request->get('responsable');
    	$logotipo=$request->request->get('logotipo');
    	
    	$repository = $this->getDoctrine()->getRepository('AppBundle:Cadena');
    	$cadena = $repository->find($id);

    	$cadena->setNombre($nombre);
    	$cadena->setResponsable($responsable);
    	$cadena->setLogotipo($logotipo);
    	
    	$em = $this->getDoctrine()->getManager();
    	$em->persist($cadena);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Cadena Modificada');
    	return $this->redirectToRoute('listarCadenas');

    }
    
    
    /**
     * @Route("/borrarCadena/{id}", name="borrarCadena")
     */
    public function borrarCadenaAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository=$em->getRepository('AppBundle:Cadena');
    	$cadena = $repository->find($id);
    	$em->remove($cadena);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Cadena borrada');
    	return $this->redirectToRoute('listarCadenas');
    }
    
     
    
}
