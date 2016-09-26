<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ZonaEnvio
 *
 * @ORM\Table(name="zona_envio")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ZonaEnvioRepository")
 */
class ZonaEnvio
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
     * @ORM\Column(name="nombre", type="string", length=100, unique=true)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="descripcion", type="text", nullable=true)
     */
    private $descripcion;

    /**
     * @var int
     *
     * @ORM\Column(name="valor", type="integer")
     */
    private $valor;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdenProduccion", mappedBy="zonaEnvio")
     **/
    private $ordenProduccion;

    public function __construct() {
        $this->ordenProduccion = new \Doctrine\Common\Collections\ArrayCollection();
    }
    


    public function __toString()
    {
        return $this->getNombre();
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
     * @return ZonaEnvio
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
     * Set descripcion
     *
     * @param string $descripcion
     * @return ZonaEnvio
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Add ordenProduccion
     *
     * @param \AppBundle\Entity\OrdenProduccion $ordenProduccion
     * @return ZonaEnvio
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
     * Set valor
     *
     * @param integer $valor
     * @return ZonaEnvio
     */
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get valor
     *
     * @return integer 
     */
    public function getValor()
    {
        return $this->valor;
    }
}
