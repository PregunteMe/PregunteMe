<?php

namespace PregunteMe\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Respuesta
 */
class Respuesta
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
    private $puntaje;

    /**
     * @var \PregunteMe\AdministracionBundle\Entity\Pregunta
     */
    private $pregunta;


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
     * @return Respuesta
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
     * Set puntaje
     *
     * @param float $puntaje
     * @return Respuesta
     */
    public function setPuntaje($puntaje)
    {
        $this->puntaje = $puntaje;

        return $this;
    }

    /**
     * Get puntaje
     *
     * @return float 
     */
    public function getPuntaje()
    {
        return $this->puntaje;
    }

    /**
     * Set pregunta
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Pregunta $pregunta
     * @return Respuesta
     */
    public function setPregunta(\PregunteMe\AdministracionBundle\Entity\Pregunta $pregunta = null)
    {
        $this->pregunta = $pregunta;

        return $this;
    }

    /**
     * Get pregunta
     *
     * @return \PregunteMe\AdministracionBundle\Entity\Pregunta 
     */
    public function getPregunta()
    {
        return $this->pregunta;
    }
}
