<?php

namespace AppBundle\Entity;



class TimeSlotEquipment
{

    private $startTime;

    private $endTime;

    private $day;


    private $id;


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
