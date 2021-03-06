<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Pedido
 * 
 * @ORM\Table(name="pedido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PedidoRepository")
 * @ORM\HasLifecycleCallbacks() 
 */
class Pedido
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
     * @ORM\Column(name="numero", type="string", length=100, unique=true)
     */
    private $numero;

    /**
     * @var int
     *
     * @ORM\Column(name="total", type="bigint")
     */
    private $total='0';

    /**
     * @var string
     *
     * @ORM\Column(name="estato", type="string", length=100, nullable=true)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=100)
     */
    private $telefono;

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

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Usuario", inversedBy="pedidos") */
    protected $usuario;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cliente", inversedBy="pedidos") */
    protected $cliente;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\ZonaEnvio", inversedBy="pedido") */
    protected $zonaEnvio;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdenProduccion", mappedBy="pedido")
     **/
    private $ordenProduccion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Venta", mappedBy="pedido")
     **/
    private $venta;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Abono", mappedBy="pedido")
     **/
    private $abono;


    public function __construct() {
        $this->ordenProduccion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->venta = new \Doctrine\Common\Collections\ArrayCollection();
        $this->abono = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Pedido
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
     * Set total
     *
     * @param integer $total
     * @return Pedido
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
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
     * Set usuario
     *
     * @param \AppBundle\Entity\Usuario $usuario
     * @return Pedido
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

    /**
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     * @return Pedido
     */
    public function setCliente(\AppBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \AppBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }

    /**
     * Add ordenProduccion
     *
     * @param \AppBundle\Entity\OrdenProduccion $ordenProduccion
     * @return Pedido
     */
    public function addOrdenProduccion(\AppBundle\Entity\OrdenProduccion $ordenProduccion)
    {
        $this->ordenProduccion[] = $ordenProduccion;

        return $this;
    }

    /**
     * Remove ordenProduccion
     *
     * @param \AppBundle\Entity\OrdenProduccion $ordenProduccion
     */
    public function removeOrdenProduccion(\AppBundle\Entity\OrdenProduccion $ordenProduccion)
    {
        $this->ordenProduccion->removeElement($ordenProduccion);
    }

    /**
     * Get ordenProduccion
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getOrdenProduccion()
    {
        return $this->ordenProduccion;
    }


    /**
     * Add venta
     *
     * @param \AppBundle\Entity\Venta $venta
     * @return Pedido
     */
    public function addVenta(\AppBundle\Entity\Venta $venta)
    {
        $this->venta[] = $venta;

        return $this;
    }

    /**
     * Remove venta
     *
     * @param \AppBundle\Entity\Venta $venta
     */
    public function removeVenta(\AppBundle\Entity\Venta $venta)
    {
        $this->venta->removeElement($venta);
    }

    /**
     * Get venta
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVenta()
    {
        return $this->venta;
    }

    /**
     * Add venta
     *
     * @param \AppBundle\Entity\Venta $venta
     * @return Pedido
     */
    public function addVentum(\AppBundle\Entity\Venta $venta)
    {
        $this->venta[] = $venta;

        return $this;
    }

    /**
     * Remove venta
     *
     * @param \AppBundle\Entity\Venta $venta
     */
    public function removeVentum(\AppBundle\Entity\Venta $venta)
    {
        $this->venta->removeElement($venta);
    }

    /**
     * Add abono
     *
     * @param \AppBundle\Entity\Abono $abono
     * @return Pedido
     */
    public function addAbono(\AppBundle\Entity\Abono $abono)
    {
        $this->abono[] = $abono;

        return $this;
    }

    /**
     * Remove abono
     *
     * @param \AppBundle\Entity\Abono $abono
     */
    public function removeAbono(\AppBundle\Entity\Abono $abono)
    {
        $this->abono->removeElement($abono);
    }

    /**
     * Get abono
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAbono()
    {
        return $this->abono;
    }
    
    /**
     * Set estado
     *
     * @param string $estado
     * @return Pedido
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
     * Set telefono
     *
     * @param string $telefono
     * @return Pedido
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
     * Set direccionEntrega
     *
     * @param string $direccionEntrega
     * @return Pedido
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
     * @return Pedido
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
     * Set destinatarioNombres
     *
     * @param string $destinatarioNombres
     * @return Pedido
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
     * @return Pedido
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
     * Set zonaEnvio
     *
     * @param \AppBundle\Entity\ZonaEnvio $zonaEnvio
     * @return Pedido
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
}
