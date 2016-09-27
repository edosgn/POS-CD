<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Despacho
 *
 * @ORM\Table(name="despacho")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DespachoRepository")
 */
class Despacho
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaEntrega", type="datetime", nullable = true)
     */
    private $fechaEntrega;

   /**
     * @var string
     *
     * @ORM\Column(name="receptor", type="text" , nullable = true)
     */
    private $receptor;

    /**
     * @var string
     *
     * @ORM\Column(name="observaciones", type="text", nullable = true)
     */
    private $observaciones;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrdenProduccionDetalle", inversedBy="despachos") */
    private $ordenProduccionDetalle;


    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="despachos") */
    private $usuario; 

     


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
     * Set fechaEntrega
     *
     * @param \DateTime $fechaEntrega
     * @return Despacho
     */
    public function setFechaEntrega($fechaEntrega)
    {
        $this->fechaEntrega = $fechaEntrega;

        return $this;
    }

    /**
     * Get fechaEntrega
     *
     * @return \DateTime 
     */
    public function getFechaEntrega()
    {
        return $this->fechaEntrega;
    }

    /**
     * Set receptor
     *
     * @param string $receptor
     * @return Despacho
     */
    public function setReceptor($receptor)
    {
        $this->receptor = $receptor;

        return $this;
    }

    /**
     * Get receptor
     *
     * @return string 
     */
    public function getReceptor()
    {
        return $this->receptor;
    }

    /**
     * Set observaciones
     *
     * @param string $observaciones
     * @return Despacho
     */
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;

        return $this;
    }

    /**
     * Get observaciones
     *
     * @return string 
     */
    public function getObservaciones()
    {
        return $this->observaciones;
    }

    /**
     * Set ordenProduccionDetalle
     *
     * @param \AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle
     * @return Despacho
     */
    public function setOrdenProduccionDetalle(\AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle = null)
    {
        $this->ordenProduccionDetalle = $ordenProduccionDetalle;

        return $this;
    }

    /**
     * Get ordenProduccionDetalle
     *
     * @return \AppBundle\Entity\OrdenProduccionDetalle 
     */
    public function getOrdenProduccionDetalle()
    {
        return $this->ordenProduccionDetalle;
    }

    /**
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     * @return Despacho
     */
    public function setUsuario(\AppBundle\Entity\Usuario $usuario = null)
    {
        $this->usuario = $usuario;

        return $this;
    }

    /**
     * Get usuario
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getUsuario()
    {
        return $this->usuario;
    }
}