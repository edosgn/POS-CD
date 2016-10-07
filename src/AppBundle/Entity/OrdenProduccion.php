<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\ORM\Mapping as ORM;

/**
 * OrdenProduccion
 *
 * @ORM\Table(name="orden_produccion")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdenProduccionRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class OrdenProduccion
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
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=100, unique=true, nullable=true)
     */
    private $numero;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_entrega", type="datetime", nullable=true)
     */
    private $fechaEntrega;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100, nullable=true)
     */
    private $estado = "Asignada";

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_mensaje", type="text")
     */
    private $descripcionMensaje;

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

    /** 
    * created Time/Date 
    * 
    * @var \DateTime 
    * 
    * @ORM\Column(name="created_at", type="datetime", nullable=false) 
    */  
    protected $createdAt;

    /** 
     * updated Time/Date 
     * 
     * @var \DateTime 
     * 
     * @ORM\Column(name="updated_at", type="datetime", nullable=false) 
     */  
    protected $updatedAt;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pedido", inversedBy="ordenProduccion") */
    protected $pedido;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Horario", inversedBy="ordenProduccion") */
    protected $horario;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prioridad", inversedBy="ordenProduccion") */
    protected $prioridad;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Detalle", inversedBy="ordenProduccion") */
    protected $detalle;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Mensaje", inversedBy="ordenProduccion") */
    protected $mensaje;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="ordenProduccion") */
    protected $responsable;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\OrdenProduccionEstado", inversedBy="ordenProduccion") */
    protected $ordenProduccionEstado;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Despacho", mappedBy="ordenProduccion")
     */
    private $despachos;

    public function __construct() {
        $this->despachos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString(){
        return $this->getNumero();
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
     * Set numero
     *
     * @param string $numero
     * @return OrdenProduccion
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero
     *
     * @return string 
     */
    public function getNumero()
    {
        return $this->numero;
    }
    
    /**
     * Set destinatarioNombres
     *
     * @param string $destinatarioNombres
     * @return OrdenProduccion
     */
    public function setDestinatarioNombres($destinatarioNombres)
    {
        $this->destinatarioNombres = $destinatarioNombres;

        return $this;
    }

    /**
     * Get destinatarioNombres
     *
     * @return string 
     */
    public function getDestinatarioNombres()
    {
        return $this->destinatarioNombres;
    }

    /**
     * Set destinatarioApellidos
     *
     * @param string $destinatarioApellidos
     * @return OrdenProduccion
     */
    public function setDestinatarioApellidos($destinatarioApellidos)
    {
        $this->destinatarioApellidos = $destinatarioApellidos;

        return $this;
    }

    /**
     * Get destinatarioApellidos
     *
     * @return string 
     */
    public function getDestinatarioApellidos()
    {
        return $this->destinatarioApellidos;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return OrdenProduccion
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }
    
    /**
     * Set fechaEntrega
     *
     * @param \DateTime $fechaEntrega
     * @return OrdenProduccion
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
     * Set direccionEntrega
     *
     * @param string $direccionEntrega
     * @return OrdenProduccion
     */
    public function setDireccionEntrega($direccionEntrega)
    {
        $this->direccionEntrega = $direccionEntrega;

        return $this;
    }

    /**
     * Get direccionEntrega
     *
     * @return string 
     */
    public function getDireccionEntrega()
    {
        return $this->direccionEntrega;
    }

    /**
     * Set descripcionDireccion
     *
     * @param string $descripcionDireccion
     * @return OrdenProduccion
     */
    public function setDescripcionDireccion($descripcionDireccion)
    {
        $this->descripcionDireccion = $descripcionDireccion;

        return $this;
    }

    /**
     * Get descripcionDireccion
     *
     * @return string 
     */
    public function getDescripcionDireccion()
    {
        return $this->descripcionDireccion;
    }

    /**
     * Set observacion
     *
     * @param string $observacion
     * @return OrdenProduccion
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
     * Set firma
     *
     * @param string $firma
     * @return OrdenProduccion
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
     * Set estado
     *
     * @param string $estado
     * @return OrdenProduccion
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return string 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /** 
     * Set createdAt 
     * 
     * @ORM\PrePersist 
     */  
    public function setCreatedAt()  
    {  
        $this->createdAt = new \DateTime('now');  
        $this->updatedAt = new \DateTime('now');  
    }  
  
    /** 
     * Get createdAt 
     * 
     * @return \DateTime 
     */  
    public function getCreatedAt()  
    {  
        return $this->createdAt;  
    }  
  
    /** 
     * Set updatedAt 
     * 
     * @ORM\PreUpdate 
     */  
    public function setUpdatedAt()  
    {  
        $this->updatedAt = new \DateTime('now');  
    }  
  
    /** 
     * Get updatedAt 
     * 
     * @return \DateTime 
     */  
    public function getUpdatedAt()  
    {  
        return $this->updatedAt;  
    }

    /**
     * Set pedido
     *
     * @param \AppBundle\Entity\Pedido $pedido
     * @return OrdenProduccion
     */
    public function setPedido(\AppBundle\Entity\Pedido $pedido = null)
    {
        $this->pedido = $pedido;

        return $this;
    }

    /**
     * Get pedido
     *
     * @return \AppBundle\Entity\Pedido 
     */
    public function getPedido()
    {
        return $this->pedido;
    }

    /**
     * Set zonaEnvio
     *
     * @param \AppBundle\Entity\ZonaEnvio $zonaEnvio
     * @return OrdenProduccion
     */
    public function setZonaEnvio(\AppBundle\Entity\ZonaEnvio $zonaEnvio = null)
    {
        $this->zonaEnvio = $zonaEnvio;

        return $this;
    }

    /**
     * Get zonaEnvio
     *
     * @return \AppBundle\Entity\ZonaEnvio 
     */
    public function getZonaEnvio()
    {
        return $this->zonaEnvio;
    }

    /**
     * Set horario
     *
     * @param \AppBundle\Entity\Horario $horario
     * @return OrdenProduccion
     */
    public function setHorario(\AppBundle\Entity\Horario $horario = null)
    {
        $this->horario = $horario;

        return $this;
    }

    /**
     * Get horario
     *
     * @return \AppBundle\Entity\Horario 
     */
    public function getHorario()
    {
        return $this->horario;
    }
    
    /**
     * Set prioridad
     *
     * @param \AppBundle\Entity\Prioridad $prioridad
     * @return OrdenProduccion
     */
    public function setPrioridad(\AppBundle\Entity\Prioridad $prioridad = null)
    {
        $this->prioridad = $prioridad;

        return $this;
    }

    /**
     * Get prioridad
     *
     * @return \AppBundle\Entity\Prioridad 
     */
    public function getPrioridad()
    {
        return $this->prioridad;
    }

    /**
     * Add despachos
     *
     * @param \AppBundle\Entity\Despacho $despachos
     * @return OrdenProduccion
     */
    public function addDespacho(\AppBundle\Entity\Despacho $despachos)
    {
        $this->despachos[] = $despachos;

        return $this;
    }

    /**
     * Remove despachos
     *
     * @param \AppBundle\Entity\Despacho $despachos
     */
    public function removeDespacho(\AppBundle\Entity\Despacho $despachos)
    {
        $this->despachos->removeElement($despachos);
    }

    /**
     * Get despachos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDespachos()
    {
        return $this->despachos;
    }

    /**
     * Set descripcionMensaje
     *
     * @param string $descripcionMensaje
     * @return OrdenProduccion
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
     * Set precio
     *
     * @param integer $precio
     * @return OrdenProduccion
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
     * @return OrdenProduccion
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
     * Set fotoObservacion
     *
     * @param string $fotoObservacion
     * @return OrdenProduccion
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
     * Set detalle
     *
     * @param \AppBundle\Entity\Detalle $detalle
     * @return OrdenProduccion
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
     * Set mensaje
     *
     * @param \AppBundle\Entity\Mensaje $mensaje
     * @return OrdenProduccion
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
     * @return OrdenProduccion
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
     * @return OrdenProduccion
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
