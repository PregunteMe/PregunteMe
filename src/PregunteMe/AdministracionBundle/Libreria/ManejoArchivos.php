<?php

namespace PregunteMe\AdministracionBundle\Libreria;


use PregunteMe\AdministracionBundle\Entity\Modulo;
use PregunteMe\AdministracionBundle\Entity\Dimension;
use PregunteMe\AdministracionBundle\Entity\Categoria;
use PregunteMe\AdministracionBundle\Entity\Indicador;
use PregunteMe\AdministracionBundle\Entity\Nivel;
use PregunteMe\AdministracionBundle\Entity\Pregunta;
use PregunteMe\AdministracionBundle\Entity\Respuesta;

class ManejoArchivos{

	public static function getDimension($t, $modulo, $nombre){
		$em = $t->getDoctrine()->getManager();

		$r_dimension = $em->getRepository('PregunteMeAdministracionBundle:Dimension');	

		$dimension = $r_dimension->findOneBy(array("modulo"=>$modulo, "nombre"=>$nombre));
		if (is_null($dimension)){
			$dimension = new Dimension();
			$dimension->setNombre($nombre);
			$dimension->setModulo($modulo);
			$dimension->setDescripcion("Sin descripcion");
			$dimension->setJustificacion("Sin justificacion");
			$dimension->setPeso(1);
			$em->persist($dimension);
			$em->flush();
		}
		return $dimension;
	}

	public static function getCategoria($t, $dimension, $nombre){
		$em = $t->getDoctrine()->getManager();

		$r_categoria = $em->getRepository('PregunteMeAdministracionBundle:Categoria');	

		$categoria = $r_categoria->findOneBy(array("dimension"=>$dimension, "nombre"=>$nombre));
		if (is_null($categoria)){
			$categoria = new Categoria();
			$categoria->setNombre($nombre);
			$categoria->setDimension($dimension);
			$categoria->setDescripcion("Sin descripcion");
			$categoria->setJustificacion("Sin justificacion");
			$categoria->setPeso(1);
			$em->persist($categoria);
			$em->flush();
		}
		return $categoria;
	}
	
	public static function getIndicador($t, $categoria, $nombre){
		$em = $t->getDoctrine()->getManager();

		$r_indicador = $em->getRepository('PregunteMeAdministracionBundle:Indicador');	

		$indicador = $r_indicador->findOneBy(array("categoria"=>$categoria, "nombre"=>$nombre));
		if (is_null($indicador)){
			$indicador = new Indicador();
			$indicador->setNombre($nombre);
			$indicador->setCategoria($categoria);
			$indicador->setDescripcion("Sin descripcion");
			$indicador->setJustificacion("Sin justificacion");
			$indicador->setPeso(1);
			$em->persist($indicador);
			$em->flush();
		}
		return $indicador;
	}
	
	public static function addPregunta($t, $indicador, $texto_pregunta){
		$em = $t->getDoctrine()->getManager();

		$r_pregunta = $em->getRepository('PregunteMeAdministracionBundle:Pregunta');
		
		if (count($indicador->getNiveles())>0){
			$niveles = $indicador->getNiveles();
			$nivel = $niveles[0];
		}else{
			$nivel = new Nivel();
			$nivel->setCardinal(1);
			$nivel->setDescripcion("Nivel 1");
			$nivel->setObservacion("O");
			$nivel->setIndicador($indicador);
			$em->persist($nivel);
			$em->flush();
			$indicador->addNivele($nivel);
			$em->persist($indicador);
			$em->flush();
		}
		
		
		

		$pregunta = $r_pregunta->findOneBy(array("nivel"=>$nivel, "texto"=>$texto_pregunta));
		if (is_null($pregunta)){
			$pregunta = new Pregunta();
			$pregunta->setTexto($texto_pregunta);
			$pregunta->setNivel($nivel);
			$pregunta->setPuntajeMin(1);
			$pregunta->setCardinal(1);
			$pregunta->setEvaluador("");
			$em->persist($pregunta);
			$em->flush();
			
			$respuesta = new Respuesta();
			$respuesta->setTexto("Muy de acuerdo");
			$respuesta->setPuntaje(1);
			$respuesta->setPregunta($pregunta);
			$em->persist($respuesta);
			$em->flush();

			$respuesta = new Respuesta();
			$respuesta->setTexto("De acuerdo");
			$respuesta->setPuntaje(0.75);
			$respuesta->setPregunta($pregunta);
			$em->persist($respuesta);
			$em->flush();

			$respuesta = new Respuesta();
			$respuesta->setTexto("Indiferente");
			$respuesta->setPuntaje(0.5);
			$respuesta->setPregunta($pregunta);
			$em->persist($respuesta);
			$em->flush();

			$respuesta = new Respuesta();
			$respuesta->setTexto("En desacuerdo");
			$respuesta->setPuntaje(0.25);
			$respuesta->setPregunta($pregunta);
			$em->persist($respuesta);
			$em->flush();
			
			$respuesta = new Respuesta();
			$respuesta->setTexto("Muy en desacuerdo");
			$respuesta->setPuntaje(0);
			$respuesta->setPregunta($pregunta);
			$em->persist($respuesta);
			$em->flush();
			
			
			
			
			
		}
		return $pregunta;
	}
	
	public static function cargarArchivo($t, $modulo, $filas){
	
		$em = $t->getDoctrine()->getManager();
		
		$dimensionActual = "";
		$categoriaActual = "";
		$indicadorActual = "";
		
		$r_dimension = $em->getRepository('PregunteMeAdministracionBundle:Dimension');	
		$r_categoria = $em->getRepository('PregunteMeAdministracionBundle:Categoria');	
		$r_indicador = $em->getRepository('PregunteMeAdministracionBundle:Indicador');	
		$r_pregunta = $em->getRepository('PregunteMeAdministracionBundle:Pregunta');	
		
		
		
		foreach($filas as $fila){
			if ($fila[0]==='Dimensiones'){
				//\Doctrine\Common\Util\Debug::dump("Primera linea");
			}else{
				if(strlen($fila[0])>0){
					$dimensionActual = $fila[0];
				}
				$dimension = ManejoArchivos::getDimension($t, $modulo, $dimensionActual);
				//\Doctrine\Common\Util\Debug::dump("Dimension: ".$dimension->getNombre());


				if(strlen($fila[1])>0){
					$categoriaActual = $fila[1];
				}
				$categoria = ManejoArchivos::getCategoria($t, $dimension, $categoriaActual);
				//\Doctrine\Common\Util\Debug::dump("Categoria: ".$categoria->getNombre());

				if(strlen($fila[2])>0){
					$indicadorActual = $fila[2];
				}
				$indicador = ManejoArchivos::getIndicador($t, $categoria, $indicadorActual);
				//\Doctrine\Common\Util\Debug::dump("Indicador: ".$indicador->getNombre());
				
				
				$i = 3;
				while(isset($fila[$i]) && strlen($fila[$i])>0){
					$pregunta = $fila[$i];
					ManejoArchivos::addPregunta($t, $indicador, $pregunta);
					$i++;
				}
				

				
			}
		}
		
		//\Doctrine\Common\Util\Debug::dump("Fin del archivo");
		
	}
}
