<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Cliente
 *
 * @ORM\Table(name="cliente")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ClienteRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Cliente
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
     * @ORM\Column(name="identificacion", type="bigint", unique=true)
     */
    private $identificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="tipo", type="string", length=255)
     */
    protected $tipo;

    /**
     * @var string
     *
     * @ORM\Column(name="empresa", type="string", length=100, nullable=true)
     */
    private $empresa;

    /**
     * @var int
     *
     * @ORM\Column(name="nit", type="string", length=100, nullable=true)
     */
    private $nit;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="apellido", type="string", length=100)
     */
    private $apellido;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_nacimiento", type="date", nullable=true)
     */
    private $fechaNacimiento;

    /**
     * @var string
     *
     * @ORM\Column(name="preferencias", type="text", nullable=true)
     */
    private $preferencias;    

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

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pedido", mappedBy="cliente")
     **/
    private $pedidos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Referencia", mappedBy="cliente")
     **/
    private $referencias;

    public function __construct() {
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->referencias = new \Doctrine\Common\Collections\ArrayCollection();
    }

        

    public function __toString()
    {
        return $this->getNombre()." ".$this->getApellido();
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
     * Set identificacion
     *
     * @param integer $identificacion
     * @return Cliente
     */
    public function setIdentificacion($identificacion)
    {
        $this->identificacion = $identificacion;

        return $this;
    }

    /**
     * Get identificacion
     *
     * @return integer 
     */
    public function getIdentificacion()
    {
        return $this->identificacion;
    }

    /**
     * Set tipo
     *
     * @param string $tipo
     * @return Cliente
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;

        return $this;
    }

    /**
     * Get tipo
     *
     * @return string 
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Cliente
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
     * Set correo
     *
     * @param string $correo
     * @return Cliente
     */
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }

    /**
     * Get correo
     *
     * @return string 
     */
    public function getCorreo()
    {
        return $this->correo;
    }

    /**
     * Set fechaNacimiento
     *
     * @param \DateTime $fechaNacimiento
     * @return Cliente
     */
    public function setFechaNacimiento($fechaNacimiento)
    {
        $this->fechaNacimiento = $fechaNacimiento;

        return $this;
    }

    /**
     * Get fechaNacimiento
     *
     * @return \DateTime 
     */
    public function getFechaNacimiento()
    {
        return $this->fechaNacimiento;
    }

    /**
     * Set preferencias
     *
     * @param string $preferencias
     * @return Cliente
     */
    public function setPreferencias($preferencias)
    {
        $this->preferencias = $preferencias;

        return $this;
    }

    /**
     * Get preferencias
     *
     * @return string 
     */
    public function getPreferencias()
    {
        return $this->preferencias;
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
     * Add pedidos
     *
     * @param \AppBundle\Entity\Pedido $pedidos
     * @return Cliente
     */
    public function addPedido(\AppBundle\Entity\Pedido $pedidos)
    {
        $this->pedidos[] = $pedidos;

        return $this;
    }

    /**
     * Remove pedidos
     *
     * @param \AppBundle\Entity\Pedido $pedidos
     */
    public function removePedido(\AppBundle\Entity\Pedido $pedidos)
    {
        $this->pedidos->removeElement($pedidos);
    }

    /**
     * Get pedidos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPedidos()
    {
        return $this->pedidos;
    }

    /**
     * Add referencias
     *
     * @param \AppBundle\Entity\Referencia $referencias
     * @return Cliente
     */
    public function addReferencia(\AppBundle\Entity\Referencia $referencias)
    {
        $this->referencias[] = $referencias;

        return $this;
    }

    /**
     * Remove referencias
     *
     * @param \AppBundle\Entity\Referencia $referencias
     */
    public function removeReferencia(\AppBundle\Entity\Referencia $referencias)
    {
        $this->referencias->removeElement($referencias);
    }

    /**
     * Get referencias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getReferencias()
    {
        return $this->referencias;
    }

    /**
     * Set nombre
     *
     * @param string $nombre
     * @return Cliente
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
     * Set apellido
     *
     * @param string $apellido
     * @return Cliente
     */
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;

        return $this;
    }

    /**
     * Get apellido
     *
     * @return string 
     */
    public function getApellido()
    {
        return $this->apellido;
    }

    /**
     * Set empresa
     *
     * @param string $empresa
     * @return Cliente
     */
    public function setEmpresa($empresa)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return string 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set nit
     *
     * @param string $nit
     * @return Cliente
     */
    public function setNit($nit)
    {
        $this->nit = $nit;

        return $this;
    }

    /**
     * Get nit
     *
     * @return string 
     */
    public function getNit()
    {
        return $this->nit;
    }
}
