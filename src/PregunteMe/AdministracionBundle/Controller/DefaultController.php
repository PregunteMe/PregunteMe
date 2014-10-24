<?php

namespace PregunteMe\AdministracionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $indicadores = $em->getRepository('PregunteMeAdministracionBundle:Indicador')->findAll();

        return $this->render('PregunteMeAdministracionBundle:Default:index.html.twig', array('indicadores' => $indicadores));
    }
}
