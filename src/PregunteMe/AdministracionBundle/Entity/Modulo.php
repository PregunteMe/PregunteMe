<?php

namespace PregunteMe\AdministracionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Modulo
 */
class Modulo
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
     * @var \Doctrine\Common\Collections\Collection
     */
    private $dimensiones;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dimensiones = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Modulo
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
     * Add dimensiones
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Dimension $dimensiones
     * @return Modulo
     */
    public function addDimensione(\PregunteMe\AdministracionBundle\Entity\Dimension $dimensiones)
    {
        $this->dimensiones[] = $dimensiones;

        return $this;
    }

    /**
     * Remove dimensiones
     *
     * @param \PregunteMe\AdministracionBundle\Entity\Dimension $dimensiones
     */
    public function removeDimensione(\PregunteMe\AdministracionBundle\Entity\Dimension $dimensiones)
    {
        $this->dimensiones->removeElement($dimensiones);
    }

    /**
     * Get dimensiones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDimensiones()
    {
        return $this->dimensiones;
    }
    
    public function __toString(){
    	return $this->nombre;
    }
    
    
}
