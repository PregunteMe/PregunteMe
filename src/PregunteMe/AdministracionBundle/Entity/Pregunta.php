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
    private $respuestas;

    /**
     * @var \PregunteMe\AdministracionBundle\Entity\Nivel
     */
    private $nivel;

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
     * Add respuestas
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Respuesta $respuestas
     * @return Pregunta
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
