<?php

namespace PregunteMe\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categoria
 */
class Categoria
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nombre;

    /**
     * @var string
     */
    private $descripcion;

    /**
     * @var string
     */
    private $justificacion;

    /**
     * @var float
     */
    private $peso;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $indicadores;

    /**
     * @var \PregunteMe\AdministracionBundle\Entity\Dimension
     */
    private $dimension;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->indicadores = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Categoria
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return Categoria
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
     * Set justificacion
     *
     * @param string $justificacion
     * @return Categoria
     */
    public function setJustificacion($justificacion)
    {
        $this->justificacion = $justificacion;

        return $this;
    }

    /**
     * Get justificacion
     *
     * @return string 
     */
    public function getJustificacion()
    {
        return $this->justificacion;
    }

    /**
     * Set peso
     *
     * @param float $peso
     * @return Categoria
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;

        return $this;
    }

    /**
     * Get peso
     *
     * @return float 
     */
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * Add indicadores
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Indicador $indicadores
     * @return Categoria
     */
    public function addIndicadore(\PregunteMe\AdministracionBundle\Entity\Indicador $indicadores)
    {
        $this->indicadores[] = $indicadores;

        return $this;
    }

    /**
     * Remove indicadores
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Indicador $indicadores
     */
    public function removeIndicadore(\PregunteMe\AdministracionBundle\Entity\Indicador $indicadores)
    {
        $this->indicadores->removeElement($indicadores);
    }

    /**
     * Get indicadores
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIndicadores()
    {
        return $this->indicadores;
    }

    /**
     * Set dimension
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Dimension $dimension
     * @return Categoria
     */
    public function setDimension(\PregunteMe\AdministracionBundle\Entity\Dimension $dimension = null)
    {
        $this->dimension = $dimension;

        return $this;
    }

    /**
     * Get dimension
     *
     * @return \PregunteMe\AdministracionBundle\Entity\Dimension 
     */
    public function getDimension()
    {
        return $this->dimension;
    }
}
