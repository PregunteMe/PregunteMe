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
	

	public function indexAction()
	{
		return $this->render('PregunteMePresentacionBundle:Web:index.html.twig', array(
			));
	}

	public function seleccionModuloAction()
	{
		$em = $this->getDoctrine()->getManager();
		
		
		$user = $this->getUser();
		$request = $this->getRequest(); 
		$session = $this->getRequest()->getSession();
		
		$m = $request->get("modulo");
		if (isset($m)){
			$session->set("modulo", $m);
			return $this->redirect($this->generateUrl('index'));	
		}
		
		$modulos = $em->getRepository('PregunteMeAdministracionBundle:Modulo')->findAll();
		return $this->render('PregunteMePresentacionBundle:Web:seleccionModulo.html.twig', array(
			"modulos"=>$modulos,
			));
	}

	public function inscripcionAction()
	{
		$user = $this->getUser();
		$request = $this->getRequest(); 
		$session = $this->getRequest()->getSession();
		
		if (is_null($user)){
			$this->get('session')->getFlashBag()->set('danger', "Por favor ingrese al sistema");
			return $this->redirect($this->generateUrl('index'));
		}
		
		$nombre = $user->getUser();
		$correo = $user->getEmail();
		$institucion = $request->get("institucion");
		$programa = $request->get("programa");
		$objeto = $request->get("objeto");
		
		if (isset($objeto)){

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

			$this->get('session')->getFlashBag()->set('success', "Nueva evaluación de ".$session->get("modulo"));
			$session->set("casoEstudio", $casoEstudio->getId());
			return $this->redirect($this->generateUrl('evaluacion'));
		}
		
		return $this->render('PregunteMePresentacionBundle:Web:inscripcion.html.twig', array(
			));
	}

	public function evaluacionAction()
	{
		$user = $this->getUser();
		$request = $this->getRequest(); 
		$session = $this->getRequest()->getSession();
		$em = $this->getDoctrine()->getManager();


		if (is_null($user)){
			$session->getFlashBag()->set('danger', "Por favor ingrese al sistema");
			return $this->redirect($this->generateUrl('index'));
		}

		$id_casoEstudio = $session->get("casoEstudio");
		if (!isset($id_casoEstudio)){
			return $this->redirect($this->generateUrl('inscripcion'));
		}
		
		$casoEstudio = $em->getRepository('PregunteMeAdministracionBundle:CasoEstudio')->find($id_casoEstudio);
		$session->getFlashBag()->set('info', "Evaluando el caso de estudio ".$casoEstudio->getId());


		$r_modulo = $em->getRepository('PregunteMeAdministracionBundle:Modulo');
		$modulo = $r_modulo->findOneByNombre($session->get("modulo"));
		
		$dimensiones = $em->getRepository('PregunteMeAdministracionBundle:Dimension')->findBy(
			array("modulo"=>$modulo)
		);
		
		//\Doctrine\Common\Util\Debug::dump($session->get("modulo"));
		//\Doctrine\Common\Util\Debug::dump("Modulo ".$modulo);
		//\Doctrine\Common\Util\Debug::dump($dimensiones);
        
		return $this->render('PregunteMePresentacionBundle:Web:evaluacion.html.twig', array(
			"dimensiones" => $dimensiones,
			"casoEstudio" => $casoEstudio
			));
	}

	public function resultadosAction()
	{
		return $this->render('PregunteMePresentacionBundle:Web:resultados.html.twig', array(
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
