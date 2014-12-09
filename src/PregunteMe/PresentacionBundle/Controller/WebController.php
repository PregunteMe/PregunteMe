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
		
		if (is_null($user)){
			$this->get('session')->getFlashBag()->set('danger', "Por favor ingrese al sistema");
			return $this->redirect($this->generateUrl('login'));
		}
		
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
			return $this->redirect($this->generateUrl('login'));
		}
		
		$modulo = $session->get('modulo');
		if (!isset($modulo) || strlen($modulo)==0){
			return $this->redirect($this->generateUrl('seleccion_modulo'));
		}
		
		$nombre = $user->getUser();
		$correo = $user->getEmail();
		$institucion = $request->get("institucion");
		$programa = $request->get("programa");
		$objeto = $request->get("objeto");
		
		if (isset($objeto)){

			$casoEstudio = new CasoEstudio();
			$casoEstudio->setUsuario($user);
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
		$r_respuesta = $em->getRepository('PregunteMeAdministracionBundle:Respuesta');
		$modulo = $r_modulo->findOneByNombre($session->get("modulo"));
		
		$dimensiones = $em->getRepository('PregunteMeAdministracionBundle:Dimension')->findBy(
			array("modulo"=>$modulo)
		);
		

		$datosPost = $request->request->all();
		
		//\Doctrine\Common\Util\Debug::dump("La cantidad parametros post es: ".count($datosPost));
		if (count($datosPost)>0){
			foreach($datosPost as $id=>$datoPost){
				//\Doctrine\Common\Util\Debug::dump($id." = ".$datoPost);
				$respuesta = $r_respuesta->find($datoPost);
				$casoEstudio->addRespuesta($respuesta);
			}
			$em->persist($casoEstudio);
			$em->flush();
			$session->getFlashBag()->set('success', "Información almacenada");
			return $this->redirect($this->generateUrl('resultados'));
        
		}
		return $this->render('PregunteMePresentacionBundle:Web:evaluacion.html.twig', array(
			"dimensiones" => $dimensiones,
			"casoEstudio" => $casoEstudio
			));
	}
	
	public function historicoAction(){
		$em = $this->getDoctrine()->getManager();
		$casosEstudio = $em->getRepository('PregunteMeAdministracionBundle:CasoEstudio')->findAll();
		
		return $this->render('PregunteMePresentacionBundle:Web:historico.html.twig', array(
			"casosEstudio" => $casosEstudio,
			));
	}

	public function resultadosAction($id)
	{
		$user = $this->getUser();
		$request = $this->getRequest(); 
		$session = $this->getRequest()->getSession();
		$em = $this->getDoctrine()->getManager();

		/*
		if (is_null($user)){
			$session->getFlashBag()->set('danger', "Por favor ingrese al sistema");
			return $this->redirect($this->generateUrl('index'));
		}
		*/
		
		if ($id==0){
			$id_casoEstudio = $session->get("casoEstudio");
		}else{
			$id_casoEstudio = $id;
		}
		if (!isset($id_casoEstudio)){
			return $this->redirect($this->generateUrl('inscripcion'));
		}
		
		$casoEstudio = $em->getRepository('PregunteMeAdministracionBundle:CasoEstudio')->find($id_casoEstudio);
		
		if (is_null($casoEstudio)){
			$session->getFlashBag()->set('danger', "No existe el caso de estudio ".$id_casoEstudio);
			return $this->redirect($this->generateUrl('index'));
		}
		
		$resultado = array();
		$pesosInternos = 0.0;
		foreach($casoEstudio->getRespuestas() as $respuesta){
			$pregunta = $respuesta->getPregunta();
			$nivel = $pregunta->getNivel();
			$indicador = $nivel->getIndicador();
			$categoria = $indicador->getCategoria();
			$dimension = $categoria->getDimension();
			
			$pre = $pregunta->getId();
			$niv = $nivel->getId();
			$ind = $indicador->getId();
			$cat = $categoria->getId();
			$dim = $dimension->getId();
			
			
			
			if (!isset($resultado[$dim])){
				$resultado[$dim] = array("nombre"=>$dimension->getNombre(), "peso"=>$dimension->getPeso(), "pesosInternos"=>0.0, "dat"=>array());
				$pesosInternos += $dimension->getPeso();
			}
			if (!isset($resultado[$dim]["dat"][$cat])){
				$resultado[$dim]["dat"][$cat] = array("nombre"=>$categoria->getNombre(), "peso"=>$categoria->getPeso(), "pesosInternos"=>0.0, "dat"=>array());
				$resultado[$dim]["pesosInternos"]+=$categoria->getPeso();
			}
			if (!isset($resultado[$dim]["dat"][$cat]["dat"][$ind])){
				$resultado[$dim]["dat"][$cat]["dat"][$ind] = array("nombre"=>$indicador->getNombre(), "peso"=>$indicador->getPeso(), "total"=>0, "acumulado"=>0);
				$resultado[$dim]["dat"][$cat]["pesosInternos"]+=$indicador->getPeso();
			}
			$resultado[$dim]["dat"][$cat]["dat"][$ind]["total"]++;
			$resultado[$dim]["dat"][$cat]["dat"][$ind]["acumulado"]+=$respuesta->getPuntaje();
			
			
		}
		
		
		$acumulado = 0.0;
		foreach($resultado as $i=>$dim){
			$resultado[$i]["acumulado"]=0;
			foreach($dim["dat"] as $j=>$cat){
				$resultado[$i]["dat"][$j]["acumulado"]=0;
				foreach($cat["dat"] as $k=>$ind){
					$ind["puntaje"] = $ind["acumulado"]/$ind["total"];
					$resultado[$i]["dat"][$j]["acumulado"] += $ind["puntaje"];
					//\Doctrine\Common\Util\Debug::dump("\t\t\tPuntaje i[".$ind["nombre"]."]".$ind["puntaje"]);
					
				}
				$resultado[$i]["dat"][$j]["puntaje"] = $resultado[$i]["dat"][$j]["acumulado"]/$cat["pesosInternos"];
				$resultado[$i]["acumulado"] += $resultado[$i]["dat"][$j]["puntaje"];
				//\Doctrine\Common\Util\Debug::dump("\t\tPuntaje c[".$cat["nombre"]."]".$resultado[$i]["dat"][$j]["puntaje"]);
			}
			$resultado[$i]["puntaje"] = $resultado[$i]["acumulado"]/$dim["pesosInternos"];
			$acumulado += $resultado[$i]["puntaje"];
			//\Doctrine\Common\Util\Debug::dump("\tPuntaje d[".$cat["nombre"]."]".$resultado[$i]["puntaje"]);
		}
		//\Doctrine\Common\Util\Debug::dump($pesosInternos);
		//\Doctrine\Common\Util\Debug::dump($resultado, 8);	
		//\Doctrine\Common\Util\Debug::dump($acumulado/$pesosInternos);

		$tablaResultado = array(array(
			"Puntaje General",
			"Dimensión", "Puntaje",
			"Categoria", "Puntaje",
			"Indicador", "Puntaje",
		));	
		
		
		//\Doctrine\Common\Util\Debug::dump("Construyendo resultado general");
		$primeraD = true;
		foreach($resultado as $i=>$dim){
			$primeraC = true;
			foreach($dim["dat"] as $j=>$cat){
				$primeraI = true;
				foreach($cat["dat"] as $k=>$ind){
					$fila = array();
					if ($primeraD){
						$fila[]=number_format ( 100*$acumulado/$pesosInternos, 2)."%";
					}else{
						$fila[]="";
					}
					$primeraD = false;
					if ($primeraC){
						$fila[]=$dim["nombre"];
						$fila[]=number_format ( 100*$resultado[$i]["puntaje"], 2)."%";
					}else{
						$fila[]="";
						$fila[]="";
					}
					$primeraC = false;
					if ($primeraI){
						$fila[]=$cat["nombre"];
						$fila[]=number_format ( 100*$resultado[$i]["dat"][$j]["puntaje"], 2)."%";
					}else{
						$fila[]="";
						$fila[]="";
					}
					$primeraI = false;
					$ind["puntaje"] = number_format ( 100*$ind["acumulado"]/$ind["total"], 2)."%";
					
					$fila[]=$ind["nombre"];
					$fila[]=$ind["puntaje"];

					$tablaResultado[]=$fila;
					
				}
			}
		}
		
		//\Doctrine\Common\Util\Debug::dump($tablaResultado);
		
		return $this->render('PregunteMePresentacionBundle:Web:resultados.html.twig', array(
			"casoEstudio" => $casoEstudio,
			"tablaResultado" => $tablaResultado,
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
			$entity->setFechaRegistro(new \Datetime());

            
            $em->persist($entity);
            $em->flush();
            
            //ToDo: Colocar en la bolsa el mensaje sobre el registro

            return $this->redirect($this->generateUrl('login'));
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
