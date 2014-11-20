<?php

namespace PregunteMe\PresentacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PregunteMe\AdministracionBundle\Entity\Indicador;
use PregunteMe\AdministracionBundle\Entity\CasoEstudio;

class WebController extends Controller
{
	var $entorno = "OVA";
	
	public function calcularDatos(){
	
		$session = $this->getRequest()->getSession();
		$usuario = $session->get("usuario");
		if (!isset($usuario)){
			$usuario = 'Anonimo';
		}
		return array(
			'usuario'=>$usuario, 
			'entorno' => $this->entorno,
			'titulo' => "PregunteMe",
			'subtitulo' => "Evaluación de ".$this->entorno,
		);
	}
	

	public function indexAction()
	{
		return $this->render('PregunteMePresentacionBundle:Web:index.html.twig', array(
				'datos'=>$this->calcularDatos(),
			));
	}

	public function inscripcionAction()
	{
		$user = $this->getUser();
		$request = $this->getRequest(); 
		$session = $this->getRequest()->getSession();
		
		if ($session->get("usuario")!="Anonimo"){
			return $this->redirect($this->generateUrl('evaluacion'));
		}
		
		
		$nombre = $request->get("nombre");
		$correo = $request->get("correo");
		$institucion = $request->get("institucion");
		$programa = $request->get("programa");
		$objeto = $request->get("objeto");
		
		$casoEstudio = new CasoEstudio();
		$casoEstudio->setNombre($nombre);
		$casoEstudio->setCorreo($correo);
		$casoEstudio->setInstitucion($institucion);
		$casoEstudio->setPrograma($programa);
		$casoEstudio->setNombreObjeto($objeto);
		$casoEstudio->setFecha(new \Datetime());
		
		
		$em = $this->getDoctrine()->getManager();
		$em->persist($casoEstudio);
		$em->flush();
		
		
		$session->set("usuario", $correo);
		$session->set("casoEstudio", $casoEstudio);
		
		return $this->render('PregunteMePresentacionBundle:Web:inscripcion.html.twig', array(
				'datos'=>$this->calcularDatos(),
			));
	}

	public function evaluacionAction()
	{
	
		$em = $this->getDoctrine()->getManager();

        $indicadores = $em->getRepository('PregunteMeAdministracionBundle:Indicador')->findAll();
        
		return $this->render('PregunteMePresentacionBundle:Web:evaluacion.html.twig', array(
				'datos'=>$this->calcularDatos(),
				'indicadores' => $indicadores
			));
	}

	public function resultadosAction()
	{
		return $this->render('PregunteMePresentacionBundle:Web:resultados.html.twig', array(
				'datos'=>$this->calcularDatos(),
			));
	}

	public function salirAction()
	{

		$session = $this->getRequest()->getSession();
		$session->remove("usuario");
		return $this->redirect($this->generateUrl('index'));
		
	}

}
