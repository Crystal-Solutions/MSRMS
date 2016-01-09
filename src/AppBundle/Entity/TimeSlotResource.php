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
        $con = Connection::getConnectionObject()->getConnection();
        if ($this->id == null) {
            $stmt = $con->prepare('INSERT INTO time_slot_resource (title,description,achieved_date) VALUES (?,?,?)');  
            $stmt->bind_param("sss",$this->title,$this->description,$this->achievedDate);  
            $stmt->execute();  
            $stmt->close();
        }else{
            $stmt = $con->prepare('UPDATE time_slot_resource SET (title,description,achieved_date) VALUES (?,?,?)');  
            $stmt->bind_param("sss",$this->title,$this->description,$this->achievedDate);  
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

        $ach = new Achievement();
        $ach->id = $id;

        $stmt = $con->prepare('SELECT title,description,achieved_date FROM time_slot_resource WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($ach->title,$ach->description,$ach->achievedDate);
        $stmt->fetch();
        $stmt->close();
        return $ach;
    }

    public static function getAll(){
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT id,title,description,achieved_date FROM time_slot_resource');
        $achievements = array();

        if ($stmt->execute()) {
            $stmt->bind_result($id,$title,$description,$date);
            
            while ( $stmt->fetch() ) {
                $ach = new Achievement();
                $ach->id = $id;
                $ach->title = $title;
                $ach->description = $description;
                $ach->achievedDate = $date;
                $achievements[] = $ach;
            }
            $stmt->close();
            return $achievements;  
            
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
