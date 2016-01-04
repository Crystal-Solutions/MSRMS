<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TimeSlotResource
 *
 * @ORM\Table(name="time_slot_resource", indexes={@ORM\Index(name="fk_time_slot_resource_sport_has_resource1_idx", columns={"sport_has_resource_id"})})
 * @ORM\Entity
 */
class TimeSlotResource
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
     * @var \AppBundle\Entity\SportHasResource
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\SportHasResource")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sport_has_resource_id", referencedColumnName="id")
     * })
     */
    private $sportHasResource;



    /**
     * Set startTime
     *
     * @param \DateTime $startTime
     *
     * @return TimeSlotResource
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
     * @return TimeSlotResource
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
     * @return TimeSlotResource
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
     * Set sportHasResource
     *
     * @param \AppBundle\Entity\SportHasResource $sportHasResource
     *
     * @return TimeSlotResource
     */
    public function setSportHasResource(\AppBundle\Entity\SportHasResource $sportHasResource = null)
    {
        $this->sportHasResource = $sportHasResource;

        return $this;
    }

    /**
     * Get sportHasResource
     *
     * @return \AppBundle\Entity\SportHasResource
     */
    public function getSportHasResource()
    {
        return $this->sportHasResource;
    }
}
