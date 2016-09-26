<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Parentesco
 *
 * @ORM\Table(name="parentesco")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParentescoRepository")
 */
class Parentesco
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Referencia", mappedBy="parentesco")
     **/
    private $referencias;

    public function __construct() {
        $this->referencias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Parentesco
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
     * Add referencias
     *
     * @param \AppBundle\Entity\Referencia $referencias
     * @return Parentesco
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
}
