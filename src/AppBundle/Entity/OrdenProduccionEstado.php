<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdenProduccionEstado
 *
 * @ORM\Table(name="orden_produccion_estado")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrdenProduccionEstadoRepository")
 */
class OrdenProduccionEstado
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
     * @ORM\Column(name="nombre", type="string", length=100)
     */
    private $nombre;

    /**
     * @var bool
     *
     * @ORM\Column(name="estado", type="boolean")
     */
    private $estado;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdenProduccionDetalle", mappedBy="ordenProduccionEstado")
     **/
    private $ordenProduccionDetalle;

    public function __construct() {
        $this->ordenProduccionDetalle = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString(){
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
     * @return OrdenProduccionEstado
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
     * Set estado
     *
     * @param boolean $estado
     * @return OrdenProduccionEstado
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado
     *
     * @return boolean 
     */
    public function getEstado()
    {
        return $this->estado;
    }

    /**
     * Add ordenProduccionDetalle
     *
     * @param \AppBundle\Entity\OrdenProduccionDetalle $ordenProduccionDetalle
     * @return OrdenProduccionEstado
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
