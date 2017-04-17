<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServicioHabitacion
 *
 * @ORM\Table(name="servicio_habitacion", indexes={@ORM\Index(name="id_servicio", columns={"id_servicio"}), @ORM\Index(name="id_habitacion", columns={"id_habitacion"})})
 * @ORM\Entity
 */
class ServicioHabitacion
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Servicio
     *
     * @ORM\ManyToOne(targetEntity="Servicio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_servicio", referencedColumnName="id")
     * })
     */
    private $idServicio;

    /**
     * @var \Habitacio
     *
     * @ORM\ManyToOne(targetEntity="Habitacio")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_habitacion", referencedColumnName="id")
     * })
     */
    private $idHabitacion;



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
     * Set idServicio
     *
     * @param \AppBundle\Entity\Servicio $idServicio
     *
     * @return ServicioHabitacion
     */
    public function setIdServicio(\AppBundle\Entity\Servicio $idServicio = null)
    {
        $this->idServicio = $idServicio;

        return $this;
    }

    /**
     * Get idServicio
     *
     * @return \AppBundle\Entity\Servicio
     */
    public function getIdServicio()
    {
        return $this->idServicio;
    }

    /**
     * Set idHabitacion
     *
     * @param \AppBundle\Entity\Habitacio $idHabitacion
     *
     * @return ServicioHabitacion
     */
    public function setIdHabitacion(\AppBundle\Entity\Habitacio $idHabitacion = null)
    {
        $this->idHabitacion = $idHabitacion;

        return $this;
    }

    /**
     * Get idHabitacion
     *
     * @return \AppBundle\Entity\Habitacio
     */
    public function getIdHabitacion()
    {
        return $this->idHabitacion;
    }
}
