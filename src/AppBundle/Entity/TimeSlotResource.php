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


    public function save()
    {
        $this->startTime = $this->startTime?$this->startTime->format('H-i'):null;
        $this->endTime = $this->endTime?$this->endTime->format('H-i'):null;

        $con = Connection::getConnectionObject()->getConnection();
        if ($this->id == null) {
            $stmt = $con->prepare('INSERT INTO time_slot_resource (sport_has_resource_id,start_time,end_time,day) VALUES (?,?,?.?)');  
            $stmt->bind_param("isss",$this->sportHasResource,$this->startTime,$this->endTime,$this->day);  
            $stmt->execute();  
            $stmt->close();
        }else{
            $stmt = $con->prepare('UPDATE time_slot_resource SET (sport_has_resource_id,start_time,end_time,day) VALUES (?,?,?.?)');  
            $stmt->bind_param("isss",$this->sportHasResource,$this->startTime,$this->endTime,$this->day);  
            $stmt->execute();  
            $stmt->close();
        }
        $con->close();
    }

    public static function getOne($id){

        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $slot = new TimeSlotResource();
        $slot->id = $id;

        $stmt = $con->prepare('SELECT sport_has_resource_id,start_time,end_time,day FROM time_slot_resource WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($this->sportHasResource,$this->startTime,$this->endTime,$this->day);
        $stmt->fetch();
        $stmt->close();
        return $slot;
    }

    public static function getAll(){
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT id,sport_has_resource_id,start_time,end_time,day FROM time_slot_resource');
        $slots = array();

        if ($stmt->execute()) {
            $stmt->bind_result($id,$sportHasResource,$startTime,$endTime,$day);
            
            while ( $stmt->fetch() ) {
                $slot = new TimeSlotResource();
                $slot->id = $id;
                $slot->sportHasResource = $sportHasResource;
                $slot->startTime = $startTime;
                $slot->endTime = $endTime;
                $slot->day = $day;
                $slots[] = $slot;
            }
            $stmt->close();
            return $slots;  
            
        }
        $stmt->close();
        return false;     
    }

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
