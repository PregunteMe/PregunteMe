<?php

namespace PregunteMe\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nivel
 */
class Nivel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $cardinal;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $observacion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $preguntas;

    /**
     * @var \PregunteMe\AdministracionBundle\Entity\Indicador
     */
    private $indicador;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->preguntas = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set cardinal
     *
     * @param integer $cardinal
     * @return Nivel
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Nivel
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return Nivel
     */
    public function setObservacion($observacion)
    {
        $this->observacion = $observacion;

        return $this;
    }

    /**
     * Get observacion
     *
     * @return string 
     */
    public function getObservacion()
    {
        return $this->observacion;
    }

    /**
     * Add preguntas
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Pregunta $preguntas
     * @return Nivel
     */
    public function addPregunta(\PregunteMe\AdministracionBundle\Entity\Pregunta $preguntas)
    {
        $this->preguntas[] = $preguntas;

        return $this;
    }

    /**
     * Remove preguntas
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Pregunta $preguntas
     */
    public function removePregunta(\PregunteMe\AdministracionBundle\Entity\Pregunta $preguntas)
    {
        $this->preguntas->removeElement($preguntas);
    }

    /**
     * Get preguntas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPreguntas()
    {
        return $this->preguntas;
    }

    /**
     * Set indicador
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Indicador $indicador
     * @return Nivel
     */
    public function setIndicador(\PregunteMe\AdministracionBundle\Entity\Indicador $indicador = null)
    {
        $this->indicador = $indicador;

        return $this;
    }

    /**
     * Get indicador
     *
     * @return \PregunteMe\AdministracionBundle\Entity\Indicador 
     */
    public function getIndicador()
    {
        return $this->indicador;
    }
}
