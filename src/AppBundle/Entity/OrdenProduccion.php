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
     * @var string
     *
     * @ORM\Column(name="destinatario_nombres", type="string", length=100)
     */
    private $destinatarioNombres;

    /**
     * @var string
     *
     * @ORM\Column(name="destinatario_apellidos", type="string", length=100)
     */
    private $destinatarioApellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=100)
     */
    private $telefono;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_entrega", type="datetime", nullable=true)
     */
    private $fechaEntrega;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion_entrega", type="string", length=255)
     */
    private $direccionEntrega;     

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_direccion", type="text", nullable=true)
     */
    private $descripcionDireccion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo_pago", type="string", length=100, nullable=true)
     */
    private $tipoPago;

    /**
     * @var string
     *
     * @ORM\Column(name="novedad", type="text", nullable=true)
     */
    private $novedad;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=100, nullable=true)
     */
    private $estado = "Sin asignar";

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

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\ZonaEnvio", inversedBy="ordenProduccion") */
    protected $zonaEnvio;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Horario", inversedBy="ordenProduccion") */
    protected $horario;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Prioridad", inversedBy="ordenProduccion") */
    protected $prioridad;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdenProduccionDetalle", mappedBy="ordenProduccion")
     **/
    private $ordenProduccionDetalle;

    public function __construct() {
        $this->ordenProduccionDetalle = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set cantidadDetalle
     *
     * @param integer $cantidadDetalle
     * @return OrdenProduccion
     */
    public function setCantidadDetalle($cantidadDetalle)
    {
        $this->cantidadDetalle = $cantidadDetalle;

        return $this;
    }

    /**
     * Get cantidadDetalle
     *
     * @return integer 
     */
    public function getCantidadDetalle()
    {
        return $this->cantidadDetalle;
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
     * Set tipoPago
     *
     * @param string $tipoPago
     * @return OrdenProduccion
     */
    public function setTipoPago($tipoPago)
    {
        $this->tipoPago = $tipoPago;

        return $this;
    }

    /**
     * Get tipoPago
     *
     * @return string 
     */
    public function getTipoPago()
    {
        return $this->tipoPago;
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
     * Set novedad
     *
     * @param string $novedad
     * @return OrdenProduccion
     */
    public function setNovedad($novedad)
    {
        $this->novedad = $novedad;

        return $this;
    }

    /**
     * Get novedad
     *
     * @return string 
     */
    public function getNovedad()
    {
        return $this->novedad;
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
     * Add ordenProduccionDetalle
     *
     * @param \AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle
     * @return OrdenProduccion
     */
    public function addOrdenProduccionDetalle(\AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle)
    {
        $this->ordenProduccionDetalle[] = $ordenProduccionDetalle;

        return $this;
    }

    /**
     * Remove ordenProduccionDetalle
     *
     * @param \AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle
     */
    public function removeOrdenProduccionDetalle(\AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle)
    {
        $this->ordenProduccionDetalle->removeElement($ordenProduccionDetalle);
    }

    /**
     * Get ordenProduccionDetalle
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrdenProduccionDetalle()
    {
        return $this->ordenProduccionDetalle;
    }
}
