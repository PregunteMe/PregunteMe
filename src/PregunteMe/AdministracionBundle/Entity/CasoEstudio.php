<?php

namespace PregunteMe\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CasoEstudio
 */
class CasoEstudio
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $institucion;

    /**
     * @var string
     */
    private $programa;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $correo;

    /**
     * @var \DateTime
     */
    private $fecha;

    /**
     * @var string
     */
    private $nombreObjeto;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $respuestas;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->respuestas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set institucion
     *
     * @param string $institucion
     * @return CasoEstudio
     */
    public function setInstitucion($institucion)
    {
        $this->institucion = $institucion;

        return $this;
    }

    /**
     * Get institucion
     *
     * @return string 
     */
    public function getInstitucion()
    {
        return $this->institucion;
    }

    /**
     * Set programa
     *
     * @param string $programa
     * @return CasoEstudio
     */
    public function setPrograma($programa)
    {
        $this->programa = $programa;

        return $this;
    }

    /**
     * Get programa
     *
     * @return string 
     */
    public function getPrograma()
    {
        return $this->programa;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return CasoEstudio
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return CasoEstudio
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return CasoEstudio
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set nombreObjeto
     *
     * @param string $nombreObjeto
     * @return CasoEstudio
     */
    public function setNombreObjeto($nombreObjeto)
    {
        $this->nombreObjeto = $nombreObjeto;

        return $this;
    }

    /**
     * Get nombreObjeto
     *
     * @return string 
     */
    public function getNombreObjeto()
    {
        return $this->nombreObjeto;
    }

    /**
     * Add respuestas
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Respuesta $respuestas
     * @return CasoEstudio
     */
    public function addRespuesta(\PregunteMe\AdministracionBundle\Entity\Respuesta $respuestas)
    {
        $this->respuestas[] = $respuestas;

        return $this;
    }

    /**
     * Remove respuestas
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Respuesta $respuestas
     */
    public function removeRespuesta(\PregunteMe\AdministracionBundle\Entity\Respuesta $respuestas)
    {
        $this->respuestas->removeElement($respuestas);
    }

    /**
     * Get respuestas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRespuestas()
    {
        return $this->respuestas;
    }
}
