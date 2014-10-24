<?php

namespace PregunteMe\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Indicador
 */
class Indicador
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $niveles;

    /**
     * @var \PregunteMe\AdministracionBundle\Entity\Categoria
     */
    private $categoria;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->niveles = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Indicador
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
     * @return Indicador
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
     * @return Indicador
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
     * Add niveles
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Nivel $niveles
     * @return Indicador
     */
    public function addNivele(\PregunteMe\AdministracionBundle\Entity\Nivel $niveles)
    {
        $this->niveles[] = $niveles;

        return $this;
    }

    /**
     * Remove niveles
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Nivel $niveles
     */
    public function removeNivele(\PregunteMe\AdministracionBundle\Entity\Nivel $niveles)
    {
        $this->niveles->removeElement($niveles);
    }

    /**
     * Get niveles
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getNiveles()
    {
        return $this->niveles;
    }

    /**
     * Set categoria
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Categoria $categoria
     * @return Indicador
     */
    public function setCategoria(\PregunteMe\AdministracionBundle\Entity\Categoria $categoria = null)
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * Get categoria
     *
     * @return \PregunteMe\AdministracionBundle\Entity\Categoria 
     */
    public function getCategoria()
    {
        return $this->categoria;
    }
}
