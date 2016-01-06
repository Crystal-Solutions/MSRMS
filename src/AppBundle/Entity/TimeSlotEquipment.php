<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TimeSlotEquipment
 *
 * @ORM\Table(name="time_slot_equipment", indexes={@ORM\Index(name="fk_time_slot_equipment_sport_has_equipment1_idx", columns={"sport_has_equipment_id"})})
 * @ORM\Entity
 */
class TimeSlotEquipment
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_time", type="time", nullable=true)
     */
    private $startTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_time", type="time", nullable=true)
     */
    private $endTime;

    /**
     * @var string
     *
     * @ORM\Column(name="day", type="string", length=25, nullable=true)
     */
    private $day;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\SportHasEquipment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SportHasEquipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sport_has_equipment_id", referencedColumnName="id")
     * })
     */
    private $sportHasEquipment;



    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return TimeSlotEquipment
     */
    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return \DateTime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param \DateTime $endTime
     *
     * @return TimeSlotEquipment
     */
    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return \DateTime
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set day
     *
     * @param string $day
     *
     * @return TimeSlotEquipment
     */
    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }

    /**
     * Get day
     *
     * @return string
     */
    public function getDay()
    {
        return $this->day;
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
     * Set sportHasEquipment
     *
     * @param \AppBundle\Entity\SportHasEquipment $sportHasEquipment
     *
     * @return TimeSlotEquipment
     */
    public function setSportHasEquipment(\AppBundle\Entity\SportHasEquipment $sportHasEquipment = null)
    {
        $this->sportHasEquipment = $sportHasEquipment;

        return $this;
    }

    /**
     * Get sportHasEquipment
     *
     * @return \AppBundle\Entity\SportHasEquipment
     */
    public function getSportHasEquipment()
    {
        return $this->sportHasEquipment;
    }
}
