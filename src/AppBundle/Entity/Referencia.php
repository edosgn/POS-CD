<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Referencia
 *
 * @ORM\Table(name="referencia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReferenciaRepository")
 */
class Referencia
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
     * @ORM\Column(name="nombres", type="string", length=100)
     */
    private $nombres;

    /**
     * @var int
     *
     * @ORM\Column(name="identificacion", type="bigint")
     */
    private $identificacion;

    /**
     * @var string
     *
     * @ORM\Column(name="apellidos", type="string", length=100)
     */
    private $apellidos;

    /**
     * @var string
     *
     * @ORM\Column(name="correo", type="string", length=255, nullable=true)
     */
    private $correo;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255, nullable=true)
     */
    private $direccion;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_especial", type="date")
     */
    private $fechaEspecial;

    /**
     * @var array
     *
     * @ORM\Column(name="intereses", type="array")
     */
    private $intereses;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion_fecha", type="string", length=255, nullable=true)
     */
    private $descripcionFecha;

    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Cliente", inversedBy="referencias") */
    protected $cliente;

     /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Parentesco", inversedBy="referencias") */
    protected $parentesco;

    public function __toString(){
        return $this->getNombres()." ".$this->getApellidos();
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
     * Set nombres
     *
     * @param string $nombres
     * @return Referencia
     */
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;

        return $this;
    }

    /**
     * Get nombres
     *
     * @return string 
     */
    public function getNombres()
    {
        return $this->nombres;
    }

    /**
     * Set identificacion
     *
     * @param integer $identificacion
     * @return Referencia
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return Referencia
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set correo
     *
     * @param string $correo
     * @return Referencia
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
     * Set telefono
     *
     * @param string $telefono
     * @return Referencia
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
     * Set direccion
     *
     * @param string $direccion
     * @return Referencia
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set fechaEspecial
     *
     * @param \DateTime $fechaEspecial
     * @return Referencia
     */
    public function setFechaEspecial($fechaEspecial)
    {
        $this->fechaEspecial = $fechaEspecial;

        return $this;
    }

    /**
     * Get fechaEspecial
     *
     * @return \DateTime 
     */
    public function getFechaEspecial()
    {
        return $this->fechaEspecial;
    }

    /**
     * Set intereses
     *
     * @param array $intereses
     * @return Referencia
     */
    public function setIntereses($intereses)
    {
        $this->intereses = $intereses;

        return $this;
    }

    /**
     * Get intereses
     *
     * @return array 
     */
    public function getIntereses()
    {
        return $this->intereses;
    }

    /**
     * Set descripcionFecha
     *
     * @param string $descripcionFecha
     * @return Referencia
     */
    public function setDescripcionFecha($descripcionFecha)
    {
        $this->descripcionFecha = $descripcionFecha;

        return $this;
    }

    /**
     * Get descripcionFecha
     *
     * @return string 
     */
    public function getDescripcionFecha()
    {
        return $this->descripcionFecha;
    }

    /**
     * Set cliente
     *
     * @param \AppBundle\Entity\Cliente $cliente
     * @return Referencia
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
     * Set parentesco
     *
     * @param \AppBundle\Entity\Parentesco $parentesco
     * @return Referencia
     */
    public function setParentesco(\AppBundle\Entity\Parentesco $parentesco = null)
    {
        $this->parentesco = $parentesco;

        return $this;
    }

    /**
     * Get parentesco
     *
     * @return \AppBundle\Entity\Parentesco 
     */
    public function getParentesco()
    {
        return $this->parentesco;
    }
}
