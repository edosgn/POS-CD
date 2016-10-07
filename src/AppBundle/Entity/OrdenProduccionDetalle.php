<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdenProduccionDetalle
 *
 * @ORM\Table(name="orden_produccion_detalle")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdenProduccionDetalleRepository")
 */
class OrdenProduccionDetalle
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
     * @var int
     *
     * @ORM\Column(name="precio", type="bigint")
     */
    private $precio = 0;

        /**
     * @var int
     *
     * @ORM\Column(name="valor_envio", type="integer", nullable=true)
     */
    private $valorEnvio;  

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_mensaje", type="text")
     */
    private $descripcionMensaje;

    /**
     * @var string
     *
     * @ORM\Column(name="observacion", type="text")
     */
    private $observacion;

    /**
     * @var string
     *
     * @ORM\Column(name="foto_observacion", type="string", length=255, nullable=true)
     */
    private $fotoObservacion;

        /**
     * @var string
     *
     * @ORM\Column(name="firma", type="string", length=100, nullable=true)
     */
    private $firma;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrdenProduccion", inversedBy="ordenProduccionDetalle") */
    protected $ordenProduccion;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Detalle", inversedBy="ordenProduccionDetalle") */
    protected $detalle;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Mensaje", inversedBy="ordenProduccionDetalle") */
    protected $mensaje;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="ordenProduccionDetalle") */
    protected $responsable;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrdenProduccionEstado", inversedBy="ordenProduccionDetalle") */
    protected $ordenProduccionEstado;

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
     * Set ordenProduccion
     *
     * @param \AppBundle\Entity\OrdenProduccion $ordenProduccion
     * @return OrdenProduccionDetalle
     */
    public function setOrdenProduccion(\AppBundle\Entity\OrdenProduccion $ordenProduccion = null)
    {
        $this->ordenProduccion = $ordenProduccion;

        return $this;
    }

    /**
     * Get ordenProduccion
     *
     * @return \AppBundle\Entity\OrdenProduccion 
     */
    public function getOrdenProduccion()
    {
        return $this->ordenProduccion;
    }

    /**
     * Set detalle
     *
     * @param \AppBundle\Entity\Detalle $detalle
     * @return OrdenProduccionDetalle
     */
    public function setDetalle(\AppBundle\Entity\Detalle $detalle = null)
    {
        $this->detalle = $detalle;

        return $this;
    }

    /**
     * Get detalle
     *
     * @return \AppBundle\Entity\Detalle 
     */
    public function getDetalle()
    {
        return $this->detalle;
    }

    /**
     * Set precio
     *
     * @param integer $precio
     * @return OrdenProduccionDetalle
     */
    public function setPrecio($precio)
    {
        $this->precio = $precio;

        return $this;
    }

    /**
     * Get precio
     *
     * @return integer 
     */
    public function getPrecio()
    {
        return $this->precio;
    }

    /**
     * Set valorEnvio
     *
     * @param integer $valorEnvio
     * @return OrdenProduccionDetalle
     */
    public function setValorEnvio($valorEnvio)
    {
        $this->valorEnvio = $valorEnvio;

        return $this;
    }

    /**
     * Get valorEnvio
     *
     * @return integer 
     */
    public function getValorEnvio()
    {
        return $this->valorEnvio;
    }

    /**
     * Set descripcionMensaje
     *
     * @param string $descripcionMensaje
     * @return OrdenProduccionDetalle
     */
    public function setDescripcionMensaje($descripcionMensaje)
    {
        $this->descripcionMensaje = $descripcionMensaje;

        return $this;
    }

    /**
     * Get descripcionMensaje
     *
     * @return string 
     */
    public function getDescripcionMensaje()
    {
        return $this->descripcionMensaje;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return OrdenProduccionDetalle
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
     * Set fotoObservacion
     *
     * @param string $fotoObservacion
     * @return OrdenProduccionDetalle
     */
    public function setFotoObservacion($fotoObservacion)
    {
        $this->fotoObservacion = $fotoObservacion;

        return $this;
    }

    /**
     * Get fotoObservacion
     *
     * @return string 
     */
    public function getFotoObservacion()
    {
        return $this->fotoObservacion;
    }

    /**
     * Set firma
     *
     * @param string $firma
     * @return OrdenProduccionDetalle
     */
    public function setFirma($firma)
    {
        $this->firma = $firma;

        return $this;
    }

    /**
     * Get firma
     *
     * @return string 
     */
    public function getFirma()
    {
        return $this->firma;
    }

    /**
     * Set mensaje
     *
     * @param \AppBundle\Entity\Mensaje $mensaje
     * @return OrdenProduccionDetalle
     */
    public function setMensaje(\AppBundle\Entity\Mensaje $mensaje = null)
    {
        $this->mensaje = $mensaje;

        return $this;
    }

    /**
     * Get mensaje
     *
     * @return \AppBundle\Entity\Mensaje 
     */
    public function getMensaje()
    {
        return $this->mensaje;
    }

    /**
     * Set responsable
     *
     * @param \AppBundle\Entity\Usuario $responsable
     * @return OrdenProduccionDetalle
     */
    public function setResponsable(\AppBundle\Entity\Usuario $responsable = null)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return \AppBundle\Entity\Usuario 
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set ordenProduccionEstado
     *
     * @param \AppBundle\Entity\OrdenProduccionEstado $ordenProduccionEstado
     * @return OrdenProduccionDetalle
     */
    public function setOrdenProduccionEstado(\AppBundle\Entity\OrdenProduccionEstado $ordenProduccionEstado = null)
    {
        $this->ordenProduccionEstado = $ordenProduccionEstado;

        return $this;
    }

    /**
     * Get ordenProduccionEstado
     *
     * @return \AppBundle\Entity\OrdenProduccionEstado 
     */
    public function getOrdenProduccionEstado()
    {
        return $this->ordenProduccionEstado;
    }
}
