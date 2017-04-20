<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Habitacio;
use AppBundle\Entity\Reserva;
use AppBundle\Entity\Cliente;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

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
     * @Route("/cancelarReserva/{id}", name="cancelarReserva")
     */
    public function cancelarReservaAction($id)
    {
    	$em = $this->getDoctrine()->getManager();
    	$repository=$em->getRepository('AppBundle:Reserva');
    	$reserva = $repository->find($id);
    	$reserva->setEstado("1");
    	$em->persist($reserva);
    	$em->flush();
    	$this->get('session')->getFlashBag()->set('succesfull', 'Reserva cancelada');
    	return $this->redirectToRoute('listarReservas');
    }
    
    
    /**
     * @Route("/cliente/{email}", name="consultarCliente")
     *
     * @method ({"GET"})
     */
    public function consultarClienteAction($email) {
    	$repository = $this->getDoctrine ()->getRepository ( 'AppBundle:Cliente' );
    	$cliente = $repository->findOneBy ( array (
    			'email' => $email
    	) );
    	if ($cliente != null) {
    		$respuesta_cliente = array (
    				'id' => $cliente->getId (),
    				'nombre' => $cliente->getNombre (),
    				'apellidos' => $cliente->getApellidos (),
    				'telefono' => $cliente->getTelefono (),
    				'nif' => $cliente->getNif (),
    				'direccion' => $cliente->getDireccion (),
    				'cod_postal' => $cliente->getCodigoPostal ()
    		);
    		return new Response ( json_encode ( $respuesta_cliente ) );
    	} else {
    		$respuesta_cliente = null;
    		return new Response ( json_encode ( $cliente ) );
    	}
    }
    
    /**
     * @Route("/reservar", name="reservarGet")
     *
     * @method ({"GET"})
     */
    public function formReservarAction() {
    	$fecha_entrada = "2017-01-14 14:25:00";
    	$fecha_salida = "2017-01-14 16:25:00";
    	$calculo_fecha = (new DateTime($fecha_entrada))->diff(new DateTime($fecha_salida));
    	$horas=$calculo_fecha->h;
    	$precio = 100;
    	$repository = $this->getDoctrine ()->getRepository ( 'AppBundle:Habitacio' );
    	$habitacion = $repository->find ( 2 );
    	$id_habitacion = $habitacion->getId ();
    	$tipo_habitacion = $habitacion->getIdTipo ()->getTipo ();
    	$num_habitacion = $habitacion->getNumero();
    	$nombre_hotel = $habitacion->getIdHotel ()->getNombre ();
    	$id_hotel = $habitacion->getIdHotel ()->getId ();
    	$direccion_hotel = $habitacion->getIdHotel ()->getDireccion ();
    	$codPostal_hotel = $habitacion->getIdHotel ()->getCodigoPostal ();
    	return $this->render ( 'AppBundle:Reserva:reservar.html.twig', array (
    			'id_hotel' => $id_hotel,
    			'id_habitacion' => $id_habitacion,
    			'tipo_habitacion' => $tipo_habitacion,
    			'nombre_hotel' => $nombre_hotel,
    			'direccion_hotel' => $direccion_hotel,
    			'codPostal_hotel' => $codPostal_hotel,
    			'precio' => $precio,
    			"fecha_entrada" => $fecha_entrada,
    			"fecha_salida" => $fecha_salida,
    			"horas"=>$horas,
    			"num_habitacion"=>$num_habitacion
    	) );
    }
    
    /**
     * @Route("/reservar", name="reservarPost")
     *
     * @method ({"POST"})
     */
    public function reservarAction(Request $request) {
    	$id_habitacion = $request->request->get ( 'id_habitacion' );
    	$repository = $this->getDoctrine ()->getRepository ( 'AppBundle:Habitacio' );
    	$habitacion = $repository->find ( $id_habitacion );
    	
    	$id_cliente = $request->request->get ( 'id_cliente' );
    	if ($id_cliente != "" || $id_cliente != null) {
    		$repository = $this->getDoctrine ()->getRepository ( 'AppBundle:Cliente' );
    		$cliente = $repository->find ( $id_cliente );
    	} else {
    		
    		$cliente = new Cliente ();
    		$cliente->setEmail ( $request->request->get ( 'email_cliente' ) );
    		$cliente->setContraseña ( $request->request->get ( 'contrasenia_cliente' ) );
    		$cliente->setNombre ( $request->request->get ( 'nombre_cliente' ) );
    		$cliente->setApellidos ( $request->request->get ( 'apellidos_cliente' ) );
    		$cliente->setTelefono ( $request->request->get ( 'telefono_cliente' ) );
    		$cliente->setDireccion ( $request->request->get ( 'direccion_cliente' ) );
    		$cliente->setCodigoPostal ( $request->request->get ( 'codPostal_cliente' ) );
    		$cliente->setNif ( $request->request->get ( 'nif_cliente' ) );
    		
    		$em = $this->getDoctrine ()->getManager ();
    		$em->persist ( $cliente );
    		$em->flush ();
    	}
    	
    	$id_hotel = $request->request->get ( 'id_hotel' );
    	$repository = $this->getDoctrine ()->getRepository ( 'AppBundle:Hotel' );
    	$hotel = $repository->find ( $id_hotel );
    	
    	$precio = $request->request->get ( 'precio' );
    	$fecha_entrada = $request->request->get ( 'fecha_entrada' );
    	$fecha_salida = $request->request->get ( 'fecha_salida' );
    	
    	$reserva = new Reserva ();
    	$reserva->setIdHabitacion ( $habitacion );
    	$reserva->setIdCliente ( $cliente );
    	$reserva->setIdHotel ( $hotel );
    	$reserva->setPrecio ( $precio );
    	$reserva->setFechaInicio ( new DateTime ( $fecha_entrada ) );
    	$reserva->setFechaFin ( new DateTime ( $fecha_salida ) );
    	$reserva->setEstado ( "0" );
    	
    	$em = $this->getDoctrine ()->getManager ();
    	$em->persist ( $reserva );
    	$em->flush ();
    	$this->get ( 'session' )->getFlashBag ()->set ( 'succesfull', 'Habitación Reservada' );
    	return $this->redirectToRoute ( 'homepage' );
    }
    
    
    /**
     * @Route("/modificarReservaGet/{id}", name="modificarReservaGet")
     *
     * @method ({"GET"})
     */
    public function formModificarReservaAction($id) {
    	
    	$repository = $this->getDoctrine ()->getRepository ( 'AppBundle:Reserva' );
    	$reserva = $repository->find ( $id );
    	$id_reserva=$reserva->getId();
    	$entrada=$reserva->getFechaInicio();
    	$salida=$reserva->getFechaFin();
    	$fecha_entrada=$entrada->format('Y-m-d H:i:s');
    	$fecha_salida=$salida->format('Y-m-d H:i:s');
    	$nombre_hotel = $reserva->getIdHotel ()->getNombre ();
    	$tipo_habitacion = $reserva->getIdHabitacion ()->getIdTipo ()->getTipo ();
    	$direccion_hotel = $reserva->getIdHotel ()->getDireccion ();
    	$codPostal_hotel = $reserva->getIdHotel ()->getCodigoPostal ();
    	$num_habitacion = $reserva->getIdHabitacion ()->getNumero();
    	$precio = $reserva->getPrecio ();
    	$calculo_fecha = (new DateTime($fecha_entrada))->diff(new DateTime($fecha_salida));
    	$horas=$calculo_fecha->h;
    	
    	return $this->render ( 'AppBundle:Reserva:modificar_reserva.html.twig', array (
    			'id_reserva'=>$id_reserva,
    			'tipo_habitacion' => $tipo_habitacion,
    			'nombre_hotel' => $nombre_hotel,
    			'direccion_hotel' => $direccion_hotel,
    			'codPostal_hotel' => $codPostal_hotel,
    			'precio' => $precio,
    			"fecha_entrada" => $fecha_entrada,
    			"fecha_salida" => $fecha_salida,
    			"horas"=>$horas,
    			"num_habitacion"=>$num_habitacion
    	) );
    }
    
    
    /**
     * @Route("/validarDisponibilidad/{id_reserva}/{fecha_entrada}/{fecha_salida}/{horas}", name="validarDisponibilidad")
     *
     * @method ({"GET"})
     */
    public function validarDisponibilidadAction($id_reserva,$fecha_entrada,$fecha_salida,$horas) {
    	$repository = $this->getDoctrine ()->getRepository ( 'AppBundle:Reserva' );
    	$reserva = $repository->findOneBy ( array (
    			'id' => $id_reserva,
    			'fechaInicio'=>new DateTime($fecha_entrada),
    			'fechaFin'=>new DateTime($fecha_salida)
    	) );
    	
    	$calculo_fecha = (new DateTime($fecha_entrada))->diff(new DateTime($fecha_salida));
    	$cambio_horas=$calculo_fecha->h;
    	
    	if (empty($reserva)&&($horas==$cambio_horas)) {
    		$mensaje = "El horario se encuentra diponibe, puedes Cambiar tu reserva!";
    		$estado="DISPONIBLE";
    		
    	} elseif(!empty($reserva)) {
    		$mensaje = "La habitación no se encuentra disponibe en ese horario!";
    		$estado="";
    	}
    	else{
    		$mensaje = "La reserva debe tener ".$horas." horas";
    		$estado="";
    	}
    	return new Response ( json_encode ( array (
    			'mensaje' => $mensaje,
    			'estado'=>$estado
    	)) );
    }
    
    
    /**
     * @Route("/modificarReservaPost", name="modificarReservaPost")
     *
     * @method ({"POST"})
     */
    public function modificarReservaAction(Request $request) {
    	
    	$id_reserva = $request->request->get ( 'id_reserva' );
    	$fecha_entrada = $request->request->get ( 'fecha_entrada' );
    	$fecha_salida = $request->request->get ( 'fecha_salida' );
    	$repository = $this->getDoctrine ()->getRepository ( 'AppBundle:Reserva' );
    	$reserva = $repository->find ($id_reserva);
    	
    	$reserva->setFechaInicio ( new DateTime ( $fecha_entrada ) );
    	$reserva->setFechaFin ( new DateTime ( $fecha_salida ) );
    	
    	$em = $this->getDoctrine ()->getManager ();
    	$em->persist ( $reserva );
    	$em->flush ();
    	$this->get ( 'session' )->getFlashBag ()->set ( 'succesfull', 'Reserva Modificada' );
    	return $this->redirectToRoute ( 'listarReservas' );
    }
    
    
}
