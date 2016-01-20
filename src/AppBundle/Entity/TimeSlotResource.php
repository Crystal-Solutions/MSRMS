<?php

namespace AppBundle\Entity;



use AppBundle\Controller\Connection;
class TimeSlotResource
{

    private $startTime;


    private $endTime;


    private $day;


    private $id;


    private $sportHasResourceId;


    public function save()
    {
        $startTime = $this->startTime?$this->startTime->format('H-i'):null;
        $endTime = $this->endTime?$this->endTime->format('H-i'):null;


        $con = Connection::getConnectionObject()->getConnection();
        if ($this->id == null) {
            $stmt = $con->prepare('INSERT INTO time_slot_resource (sport_has_resource_id,start_time,end_time,`day`) VALUES (?,?,?,?)');
            $stmt->bind_param("isss",$this->sportHasResourceId,$startTime,$endTime,$this->day);
            $stmt->execute();  
            $stmt->close();
        }else{
            $stmt = $con->prepare('UPDATE time_slot_resource SET (sport_has_resource_id,start_time,end_time,`day`) VALUES (?,?,?,?)');
            $stmt->bind_param("isss",$this->sportHasResourceId,$startTime,$endTime,$this->day);
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

        $t = new TimeSlotResource();

        $stmt->bind_result($t->sportHasResourceId,$t->startTime,$t->endTime,$t->day);
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
                $slot->sportHasResourceId = $sportHasResource;
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

    public function setStartTime($startTime)
    {
        $this->startTime = $startTime;

        return $this;
    }

    public function getStartTime()
    {
        return $this->startTime;
    }

    public function setEndTime($endTime)
    {
        $this->endTime = $endTime;

        return $this;
    }


    public function getEndTime()
    {
        return $this->endTime;
    }


    public function setDay($day)
    {
        $this->day = $day;

        return $this;
    }


    public function getDay()
    {
        return $this->day;
    }


    public function getId()
    {
        return $this->id;
    }


    public function setSportHasResourceId( $sportHasResourceId )
    {
        $this->sportHasResourceId = $sportHasResourceId;

        return $this;
    }


    public function getSportHasResourceId()
    {
        return $this->sportHasResourceId;
    }
}
