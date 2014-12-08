<?php

namespace PregunteMe\AdministracionBundle\Entity;
use Symfony\Component\Security\Core\User\UserInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * Usuario
 */
class Usuario implements UserInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $pass;

    /**
     * @var string
     */
    private $email;

    /**
     * @var \DateTime
     */
    private $fechaRegistro;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $casosEstudio;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->casosEstudio = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set user
     *
     * @param string $user
     * @return Usuario
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set pass
     *
     * @param string $pass
     * @return Usuario
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string 
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Usuario
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set fechaRegistro
     *
     * @param \DateTime $fechaRegistro
     * @return Usuario
     */
    public function setFechaRegistro($fechaRegistro)
    {
        $this->fechaRegistro = $fechaRegistro;

        return $this;
    }

    /**
     * Get fechaRegistro
     *
     * @return \DateTime 
     */
    public function getFechaRegistro()
    {
        return $this->fechaRegistro;
    }

    /**
     * Add casosEstudio
     *
     * @param \PregunteMe\AdministracionBundle\Entity\CasoEstudio $casosEstudio
     * @return Usuario
     */
    public function addCasosEstudio(\PregunteMe\AdministracionBundle\Entity\CasoEstudio $casosEstudio)
    {
        $this->casosEstudio[] = $casosEstudio;

        return $this;
    }

    /**
     * Remove casosEstudio
     *
     * @param \PregunteMe\AdministracionBundle\Entity\CasoEstudio $casosEstudio
     */
    public function removeCasosEstudio(\PregunteMe\AdministracionBundle\Entity\CasoEstudio $casosEstudio)
    {
        $this->casosEstudio->removeElement($casosEstudio);
    }

    /**
     * Get casosEstudio
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCasosEstudio()
    {
        return $this->casosEstudio;
    }
    
    
    public function getPassword(){
	    return $this->pass;
    }

    public function getSalt(){
	    return "123654789";
    }
    public function getRoles(){
    	return array("ROLE_USUARIO");
    }
    public function getUserName(){
    	return $this->user;
    }
    public function eraseCredentials()
	{
	}
	public function isEqualTo(UserInterface $user)
	{
		if (!$user instanceof Usuario) {
			return false;
		}
		if ($this->pass !== $user->getPassword()) {
			return false;
		}
		if ($this->getSalt() !== $user->getSalt()) {
			return false;
		}
		if ($this->user !== $user->getUsername()) {
			return false;
		}
		return true;
	}
    
}
