<?php

namespace PregunteMe\PresentacionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use PregunteMe\AdministracionBundle\Entity\Indicador;
use PregunteMe\AdministracionBundle\Entity\CasoEstudio;

class FormularioController extends Controller
{
	public function indexAction()
	{
		$em = $this->getDoctrine()->getManager();
		$dimensiones = $em->getRepository('PregunteMeAdministracionBundle:Dimension')->findAll();
		
		return $this->render('PregunteMePresentacionBundle:Formulario:index.html.twig', array(
				'dimensiones'=>$dimensiones,
			));
	}
	

	public function dimensionAction($id)
	{
		$em = $this->getDoctrine()->getManager();
		$categorias = $em->getRepository('PregunteMeAdministracionBundle:Categoria')->findBy(array('id'=>$id));
	
		return $this->render('PregunteMePresentacionBundle:Formulario:dimension.html.twig', array(
				'categorias'=>$categorias,
		));
	}

}