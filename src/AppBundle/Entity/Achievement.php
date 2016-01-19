<?php

namespace AppBundle\Entity;

use AppBundle\Controller\Connection;


class Achievement
{

    private $title;


    private $description;


    private $achievedDate;


    public $id;

    private $playerInvolvedInSport;

    private $playerInvolvedInSportId;

    public function save()
    {
        $this->achievedDate = $this->achievedDate->format('Y-m-d');
        $con = Connection::getConnectionObject()->getConnection();
        if ($this->id == null) {
            $stmt = $con->prepare('INSERT INTO achievement (title,description,achieved_date,player_involved_in_sport_id) VALUES (?,?,?,?)');  
            $stmt->bind_param("sssi",$this->title,$this->description,$this->achievedDate,$this->playerInvolvedInSportId);
            $stmt->execute();  
            $stmt->close();
        }else{
            $stmt = $con->prepare('UPDATE achievement SET (title,description,achieved_date,player_involved_in_sport_id) VALUES (?,?,?,?)');  
            $stmt->bind_param("sssi",$this->title,$this->description,$this->achievedDate,$this->playerInvolvedInSportId);
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

        // $stmt = $con->prepare('SELECT title,description,achieved_date,player_involved_in_sport_id FROM achievement WHERE player_involved_in_sport_id=?');
        $stmt = $con->prepare('SELECT title,description,achieved_date,player_involved_in_sport_id FROM achievement WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($ach->title,$ach->description,$ach->achievedDate,$ach->playerInvolvedInSportId);
        $stmt->fetch();
        $stmt->close();
        
        $ach->setAchievedDate(new \DateTime($ach->getAchievedDate()));

        return $ach;
    }

    public static function getAll(){
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT id,title,description,achieved_date,player_involved_in_sport_id FROM achievement');
        $achievements = array();

        if ($stmt->execute()) {
            $stmt->bind_result($id,$title,$description,$date,$playerInvolvedInSportId);
            
            while ( $stmt->fetch() ) {
                $ach = new Achievement();
                $ach->id = $id;
                $ach->title = $title;
                $ach->description = $description;
                $ach->achievedDate = $date;
                $ach->playerInvolvedInSportId = $playerInvolvedInSportId;


                $ach->setAchievedDate(new \DateTime($ach->getAchievedDate()));
                $achievements[] = $ach;
            }
            $stmt->close();
            return $achievements;  
            
        }
        $stmt->close();
        return false;     
    }

    public static function getPlayerAchievements($player_involved_in_sport_id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $playerAchievements = array(); //Make an empty array - don't mind the name
        $stmt = $con->prepare('SELECT id,title, description, achieved_date, player_involved_in_sport_id FROM achievement WHERE player_involved_in_sport_id=?');
        $stmt->bind_param("s",$player_involved_in_sport_id);
        $stmt->execute();

        $stmt->bind_result($id,$title,$description,$achievedDate,$playerInvolvedInSportId);
        while($stmt->fetch())
        {
            $achievement = new Achievement();
            $achievement->id=$id;
            //check here k
            $achievement->setTitle($title);
            $achievement->setDescription($description);
            $achievement->setAchievedDate($achievedDate);
            $achievement->setPlayerInvolvedInSportId($playerInvolvedInSportId);
          
          

            array_push($playerAchievements,$achievement); //Push one by one
        }
        $stmt->close();
        
        return $playerAchievements;

    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Achievement
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Achievement
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set achievedDate
     *
     * @param \DateTime $achievedDate
     *
     * @return Achievement
     */
    public function setAchievedDate($achievedDate)
    {
        $this->achievedDate = $achievedDate;

        return $this;
    }

    /**
     * Get achievedDate
     *
     * @return \DateTime
     */
    public function getAchievedDate()
    {
        return $this->achievedDate;
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
     * Set playerInvolvedInSport
     *
     * @param \AppBundle\Entity\PlayerInvolvedInSport $playerInvolvedInSport
     *
     * @return Achievement
     */
    public function setPlayerInvolvedInSport(\AppBundle\Entity\PlayerInvolvedInSport $playerInvolvedInSport = null)
    {
        $this->playerInvolvedInSport = $playerInvolvedInSport;

        return $this;
    }

    /**
     * Get playerInvolvedInSport
     *
     * @return \AppBundle\Entity\PlayerInvolvedInSport
     */
    public function getPlayerInvolvedInSport()
    {
        return $this->playerInvolvedInSport;
    }

    /////////// playerInvolvedInSportID

    public function setPlayerInvolvedInSportId($playerInvolvedInSportId)
    {
        $this->playerInvolvedInSportId= $playerInvolvedInSportId;

        return $this;
    }


    public function getPlayerInvolvedInSportId()
    {
        return $this->playerInvolvedInSportId;

    }

}
