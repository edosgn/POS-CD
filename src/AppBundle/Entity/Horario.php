<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Horario
 *
 * @ORM\Table(name="horario")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\HorarioRepository")
 */
class Horario
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
     * @ORM\Column(name="inicio", type="integer")
     */
    private $inicio;

    /**
     * @var int
     *
     * @ORM\Column(name="final", type="integer")
     */
    private $final;

    /**
     * @var string
     *
     * @ORM\Column(name="jornada", type="string", length=2)
     */
    private $jornada;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\OrdenProduccion", mappedBy="horario")
     **/
    private $ordenProduccion;

    public function __construct() {
        $this->ordenProduccion = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return strval($this->getInicio()).' - '.strval($this->getFinal()).' '.$this->getJornada();
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
     * Set inicio
     *
     * @param integer $inicio
     * @return Horario
     */
    public function setInicio($inicio)
    {
        $this->inicio = $inicio;

        return $this;
    }

    /**
     * Get inicio
     *
     * @return integer 
     */
    public function getInicio()
    {
        return $this->inicio;
    }

    /**
     * Set final
     *
     * @param integer $final
     * @return Horario
     */
    public function setFinal($final)
    {
        $this->final = $final;

        return $this;
    }

    /**
     * Get final
     *
     * @return integer 
     */
    public function getFinal()
    {
        return $this->final;
    }

    /**
     * Set jornada
     *
     * @param string $jornada
     * @return Horario
     */
    public function setJornada($jornada)
    {
        $this->jornada = $jornada;

        return $this;
    }

    /**
     * Get jornada
     *
     * @return string 
     */
    public function getJornada()
    {
        return $this->jornada;
    }

    /**
     * Add ordenProduccion
     *
     * @param \AppBundle\Entity\OrdenProduccion $ordenProduccion
     * @return Horario
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
