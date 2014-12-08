<?php

namespace PregunteMe\AdministracionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use PregunteMe\AdministracionBundle\Entity\Modulo;
use PregunteMe\AdministracionBundle\Libreria\ManejoArchivos;

class ContenidosController extends Controller
{
	public function cargarArchivoAction()
	{
		$user = $this->getUser();
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		if (is_null($user)){
			return $this->redirect($this->generateUrl('index'));
		}
		
		$nombremodulo = $request->get("modulo");
		
		if (!is_null($nombremodulo)){
			$documento = $request->files->get("documento");
			$r_modulo = $em->getRepository('PregunteMeAdministracionBundle:Modulo');
			$modulo = $r_modulo->findOneByNombre($nombremodulo);
			if (is_null($modulo)){
				$modulo = new Modulo();
				$modulo->setNombre($nombremodulo);
				$em->persist($modulo);
				$em->flush();
			}
			
			if (($documento instanceof UploadedFile) && $documento->getError()==0){
				if ($documento->getSize()<30000000){
					$nombreOriginal = $documento->getClientOriginalName();
					$this->get('session')->getFlashBag()->set('info', "Archivo subido ok ".$documento->getClientOriginalName()." - ".$documento->getPath()." tipo ".$documento->getClientOriginalExtension());
					$tipoArchivo = $documento->getClientOriginalExtension();
					$tiposInValidos = array("csv");
					if (in_array(strtolower($tipoArchivo), $tiposInValidos)){

						$dir = __DIR__.'/../../../../web/uploads/';
						$nombreArchivo = $dir.$documento->getClientOriginalName();
						$documento->move($dir, $documento->getClientOriginalName());
						$file = fopen($nombreArchivo,"r");
						$filas = array();
						
						while(! feof($file))
						{
							$filas[] = fgetcsv($file);
						}

						fclose($file);
						
						//\Doctrine\Common\Util\Debug::dump($datos);
						ManejoArchivos::cargarArchivo($this, $modulo, $filas);


						$this->get('session')->getFlashBag()->set('success', "El archivo es cargado correctamente ");
					
					}else{
						$this->get('session')->getFlashBag()->set('error', "Archivo invalido, solo se pueden ajuntar ".implode(", ", $tiposInValidos));
					}
				}else{
					$this->get('session')->getFlashBag()->set('error', "Tamaño del archivo muy grande, por favor subir uno menor");
				}
			}else{
				$this->get('session')->getFlashBag()->set('error', "Error en el archivo adjunto");
			}
		}
		
		return $this->render('PregunteMeAdministracionBundle:Contenidos:cargarArchivo.html.twig', array(
				// ...
			));
	}

	public function descargarArchivoAction()
	{
		return $this->render('PregunteMeAdministracionBundle:Contenidos:descargarArchivo.html.twig', array(
				// ...
			));
	}

}
