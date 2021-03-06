<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;


/**
 * Usuario
 *
 * @ORM\Table(name="usuario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UsuarioRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Usuario implements UserInterface
{
    function eraseCredentials()
    {
    }

    function getRoles()
    {
        $varRole=$this->getRole();
        return array($varRole);
    }

    function getUsername()
    {
        return $this->getCorreo();
    }

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
     * @var int
     *
     * @ORM\Column(name="identificacion", type="bigint", unique=true)
     */
    private $identificacion;

    /**
     * @var int
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="estado", type="string", length=10)
     */
    private $estado;

    /**
     * @var string
     *
     * @ORM\Column(name="foto", type="string", length=100, nullable=true)
     */
    private $foto  = "default.jpg";

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
     * @var string
     *
     * @ORM\Column(name="role", type="string", length=50)
     */
    protected $role;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @var int
     *
     * @ORM\Column(name="pin", type="string", length=4, nullable=true)
     */
    private $pin;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=255)
     */
    protected $salt;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Pedido", mappedBy="usuario")
     **/
    private $pedidos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Abono", mappedBy="usuario")
     **/
    private $abonos;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdenProduccion", mappedBy="responsable")
     **/
    private $ordenProduccion;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\UsuarioCategoria", mappedBy="responsable")
     **/
    private $usuarioCategoria;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Despacho", mappedBy="usuario")
     */
    protected $despachos;

    public function __construct() {
        $this->pedidos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->ordenProduccion = new \Doctrine\Common\Collections\ArrayCollection();
        $this->usuarioCategoria = new \Doctrine\Common\Collections\ArrayCollection();
        $this->despachos = new \Doctrine\Common\Collections\ArrayCollection();
        $this->abonos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set nombre
     *
     * @param string $nombre
     * @return Usuario
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
     * @return Usuario
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
     * Set identificacion
     *
     * @param integer $identificacion
     * @return Usuario
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
     * Set telefono
     *
     * @param string $telefono
     * @return Usuario
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
     * @return Usuario
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
     * Set estado
     *
     * @param string $estado
     * @return Usuario
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
     * Set foto
     *
     * @param string $foto
     * @return Usuario
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string 
     */
    public function getFoto()
    {
        return $this->foto;
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
     * Set role
     *
     * @param string $role
     * @return Usuario
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
    * Set password
    *
    * @param string $password
    * @return Usuario
    */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set salt
     *
     * @param string $salt
     * @return Usuario
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;

        return $this;
    }

    /**
     * Get salt
     *
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }


    /**
     * Add pedidos
     *
     * @param \AppBundle\Entity\Pedido $pedidos
     * @return Usuario
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
     * Add usuarioCategoria
     *
     * @param \AppBundle\Entity\UsuarioCategoria $usuarioCategoria
     * @return Usuario
     */
    public function addUsuarioCategorium(\AppBundle\Entity\UsuarioCategoria $usuarioCategoria)
    {
        $this->usuarioCategoria[] = $usuarioCategoria;

        return $this;
    }

    /**
     * Remove usuarioCategoria
     *
     * @param \AppBundle\Entity\UsuarioCategoria $usuarioCategoria
     */
    public function removeUsuarioCategorium(\AppBundle\Entity\UsuarioCategoria $usuarioCategoria)
    {
        $this->usuarioCategoria->removeElement($usuarioCategoria);
    }

    /**
     * Get usuarioCategoria
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarioCategoria()
    {
        return $this->usuarioCategoria;
    }

    /**
     * Set pin
     *
     * @param string $pin
     * @return Usuario
     */
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get pin
     *
     * @return string 
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Add despachos
     *
     * @param \AppBundle\Entity\Despacho $despachos
     * @return Usuario
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
     * Add abonos
     *
     * @param \AppBundle\Entity\Abono $abonos
     * @return Usuario
     */
    public function addAbono(\AppBundle\Entity\Abono $abonos)
    {
        $this->abonos[] = $abonos;

        return $this;
    }

    /**
     * Remove abonos
     *
     * @param \AppBundle\Entity\Abono $abonos
     */
    public function removeAbono(\AppBundle\Entity\Abono $abonos)
    {
        $this->abonos->removeElement($abonos);
    }

    /**
     * Get abonos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAbonos()
    {
        return $this->abonos;
    }

    /**
     * Add ordenProduccion
     *
     * @param \AppBundle\Entity\OrdenProduccion $ordenProduccion
     * @return Usuario
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
}
