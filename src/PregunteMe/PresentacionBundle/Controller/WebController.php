<?php

namespace PregunteMe\PresentacionBundle\Controller;

use Symfony\Component\Security\Core\SecurityContext;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PregunteMe\AdministracionBundle\Form\UsuarioType;

use PregunteMe\AdministracionBundle\Entity\Usuario;
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
	
	
	
	///////////////////// Manejo de usuarios
	
	public function registroAction()
    {
    	$request = $this->get('request');
		$entity = new Usuario();
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('registro'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registrarse'));
        
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $factory = $this->get('security.encoder_factory');
            $encoder = $factory->getEncoder($entity);
			$password = $encoder->encodePassword($entity->getPassword(), $entity->getSalt());
			$entity->setPass($password);

            
            $em->persist($entity);
            $em->flush();
            
            //ToDo: Colocar en la bolsa el mensaje sobre el registro

            return $this->redirect($this->generateUrl('index'));
        }

        return $this->render('PregunteMePresentacionBundle:Web:registro.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));

    }

    public function loginAction()
    {
		$request = $this->getRequest();
		$session = $request->getSession();
		// get the login error if there is one
		if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
			$error = $request->attributes->get(
				SecurityContext::AUTHENTICATION_ERROR
			);
		} else {
			$error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
			$session->remove(SecurityContext::AUTHENTICATION_ERROR);
		}

		return $this->render(
				'PregunteMePresentacionBundle:Web:login.html.twig',
				array(
					// last username entered by the user
					'last_username' => $session->get(SecurityContext::LAST_USERNAME),
					'error'=> $error,
				)
			);
	}
}
