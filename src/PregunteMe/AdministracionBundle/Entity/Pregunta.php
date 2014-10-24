<?php

namespace PregunteMe\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pregunta
 */
class Pregunta
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $texto;

    /**
     * @var float
     */
    private $puntajeMin;

    /**
     * @var string
     */
    private $evaluador;

    /**
     * @var integer
     */
    private $cardinal;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $respuesta;

    /**
     * @var \PregunteMe\AdministracionBundle\Entity\Nivel
     */
    private $nivel;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->respuesta = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set texto
     *
     * @param string $texto
     * @return Pregunta
     */
    public function setTexto($texto)
    {
        $this->texto = $texto;

        return $this;
    }

    /**
     * Get texto
     *
     * @return string 
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Set puntajeMin
     *
     * @param float $puntajeMin
     * @return Pregunta
     */
    public function setPuntajeMin($puntajeMin)
    {
        $this->puntajeMin = $puntajeMin;

        return $this;
    }

    /**
     * Get puntajeMin
     *
     * @return float 
     */
    public function getPuntajeMin()
    {
        return $this->puntajeMin;
    }

    /**
     * Set evaluador
     *
     * @param string $evaluador
     * @return Pregunta
     */
    public function setEvaluador($evaluador)
    {
        $this->evaluador = $evaluador;

        return $this;
    }

    /**
     * Get evaluador
     *
     * @return string 
     */
    public function getEvaluador()
    {
        return $this->evaluador;
    }

    /**
     * Set cardinal
     *
     * @param integer $cardinal
     * @return Pregunta
     */
    public function setCardinal($cardinal)
    {
        $this->cardinal = $cardinal;

        return $this;
    }

    /**
     * Get cardinal
     *
     * @return integer 
     */
    public function getCardinal()
    {
        return $this->cardinal;
    }

    /**
     * Add respuesta
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Respuesta $respuesta
     * @return Pregunta
     */
    public function addRespuestum(\PregunteMe\AdministracionBundle\Entity\Respuesta $respuesta)
    {
        $this->respuesta[] = $respuesta;

        return $this;
    }

    /**
     * Remove respuesta
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Respuesta $respuesta
     */
    public function removeRespuestum(\PregunteMe\AdministracionBundle\Entity\Respuesta $respuesta)
    {
        $this->respuesta->removeElement($respuesta);
    }

    /**
     * Get respuesta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRespuesta()
    {
        return $this->respuesta;
    }

    /**
     * Set nivel
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Nivel $nivel
     * @return Pregunta
     */
    public function setNivel(\PregunteMe\AdministracionBundle\Entity\Nivel $nivel = null)
    {
        $this->nivel = $nivel;

        return $this;
    }

    /**
     * Get nivel
     *
     * @return \PregunteMe\AdministracionBundle\Entity\Nivel 
     */
    public function getNivel()
    {
        return $this->nivel;
    }
}
