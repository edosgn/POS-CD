<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abono
 *
 * @ORM\Table(name="abono")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AbonoRepository")
 */
class Abono
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
     * @ORM\Column(name="fecha_pago", type="datetime")
     */
    private $fechaPago;

    /**
     * @var string
     *
     * @ORM\Column(name="valor_abono", type="string", length=100)
     */
    private $valorAbono;    

    /**
     * @var string
     *
     * @ORM\Column(name="saldo", type="string", length=100)
     */
    private $saldo;

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


    /** @ORM\ManyToOne(targetEntity="AppBundle\Entity\Pedido", inversedBy="abono") */
    protected $pedido;


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
     * Set fechaPago
     *
     * @param string $fechaPago
     * @return Abono
     */
    public function setFechaPago($fechaPago)
    {
        $this->fechaPago = $fechaPago;

        return $this;
    }

    /**
     * Get fechaPago
     *
     * @return string 
     */
    public function getFechaPago()
    {
        return $this->fechaPago;
    }

    /**
     * Set valorAbono
     *
     * @param string $valorAbono
     * @return Abono
     */
    public function setValorAbono($valorAbono)
    {
        $this->valorAbono = $valorAbono;

        return $this;
    }

    /**
     * Get valorAbono
     *
     * @return string 
     */
    public function getValorAbono()
    {
        return $this->valorAbono;
    }
    
    /**
     * Set saldo
     *
     * @param string $saldo
     * @return Abono
     */
    public function setSaldo($saldo)
    {
        $this->saldo = $saldo;

        return $this;
    }

    /**
     * Get saldo
     *
     * @return string 
     */
    public function getSaldo()
    {
        return $this->saldo;
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
     * @return Abono
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
}
