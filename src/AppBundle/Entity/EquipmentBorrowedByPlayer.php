<?php

namespace AppBundle\Entity;

use AppBundle\Controller\Connection;
use AppBundle\Entity\Player; 

class EquipmentBorrowedByPlayer
{

   
    private $amount;

    private $borrowedTime;

    private $dueTime;

    private $returnedTime;

    private $issueDetails;

    private $id;

    private $player;


    private $equipment;

    public $equipment_id;
    public $player_id;
    public $indexNumber;
    public $equipmentName;

// get index from id
    public function setIndexNumber($id)
    {
    $this->indexNumber= $id;
      return $this;
  }

  
    //-----------Validation related stuff------------------------------------------------------
    private $errorMessage;
    public function getError(){ return $this->errorMessage;}

    public function validate()
    {
        $this->errorMessage = "";
       /* if ( ( (!preg_match("/([\d]{6})(([A-Z])|([a-z]))/", $this->player_id)) && strlen($this->player_id)!=7 ) )
            $this->errorMessage = "Player ID is not valid";*/

        $players =  Player::getAll();
        $playerIds = array();
        foreach ($players as $player) {
            $playerIds[$player->getIndexNumber()] = $player->getId(); 
        }

            if (in_array($this->player_id, $playerIds))$this->errorMeassage = "Player ID is not valid";
    /**    if(strtotime($this->borrowedTime->format('Y-m-d H-i-s')) > strtotime("+0 YEAR") >strttotime("+0 MONTH"),"-1 DAY") || strtotime($this->borrowedTime->format('Y-m-d H-i-s')) < strtotime("+0 YEAR","+0 MONTH","+0 DAY"))
            $this->errorMessage = "Borrowed Time is not valid";

        if(strtotime($this->dueTime->format('Y-m-d H-i-s')) > strtotime("+0 YEAR","+0 MONTH","-1 DAY") || strtotime($this->dueTime->format('Y-m-d H-i-s')) < strtotime("+0 YEAR","+0 MONTH","+0 DAY"))
            $this->errorMessage = "Due Time is not valid";**/

        if(($this->borrowedTime) > ($this->dueTime))$this->errorMessage="Due Time should be a date after Borrowed Time";
       


        //Return true if error message is "" (no eror)
        //Else return false
        return $this->errorMessage == "";
    }
    //--------------------------------------------------------------------------------------------

    
    public function save()
    {
        $this->borrowedTime = $this->borrowedTime?$this->borrowedTime->format('Y-m-d H-i-s'):null;
        $this->dueTime = $this->dueTime?$this->dueTime->format('Y-m-d H-i-s'):null;
        $this->returnedTime = $this->returnedTime?$this->returnedTime->format('Y-m-d H-i-s'):null;

        if($this->id ==null)
        {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('INSERT INTO `equipment_borrowed_by_player` (`equipment_id`,`player_id`,`amount`, `borrowed_time`, `due_time`, `returned_time`, `issue_details`) VALUES (?,?,?,?,?,?,?)');  
            $stmt->bind_param("iiissss",$this->equipment_id,$this->player_id,$this->amount,$this->borrowedTime,$this->dueTime,$this->returnedTime,$this->issueDetails);  
            $stmt->execute();  
            $stmt->close();
        }
        else
        {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('UPDATE equipment_borrowed_by_player SET equipment_id =?,player_id=?,amount=?,borrowed_time=?,due_time=?,returned_time=?,issue_details=? WHERE id = ?');  
            $stmt->bind_param("iiissssi",$this->equipment_id,$this->player_id,$this->amount,$this->borrowedTime,$this->dueTime,$this->returnedTime,$this->issueDetails,$this->id);  
            $stmt->execute();  
            $stmt->close();   
        }
    }

    public static function getOne($id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $equipmentBorrowedByPlayer = new EquipmentBorrowedByPlayer();
        $stmt = $con->prepare('SELECT equipment_borrowed_by_player.id,equipment_borrowed_by_player.equipment_id,equipment_borrowed_by_player.player_id,equipment_borrowed_by_player.amount,equipment_borrowed_by_player.borrowed_time,equipment_borrowed_by_player.due_time,equipment_borrowed_by_player.returned_time,equipment_borrowed_by_player.issue_details,player.index_number,equipment.name FROM equipment_borrowed_by_player,player,equipment WHERE equipment_borrowed_by_player.id=? AND equipment_borrowed_by_player.player_id=player.id AND equipment_borrowed_by_player.equipment_id=equipment.id');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($equipmentBorrowedByPlayer->id,$equipmentBorrowedByPlayer->equipment_id,$equipmentBorrowedByPlayer->player_id,$equipmentBorrowedByPlayer->amount,$equipmentBorrowedByPlayer->borrowedTime,$equipmentBorrowedByPlayer->dueTime,$equipmentBorrowedByPlayer->returnedTime,$equipmentBorrowedByPlayer->issueDetails, $equipmentBorrowedByPlayer->indexNumber,$equipmentBorrowedByPlayer->equipmentName);
        $stmt->fetch();
        $stmt->close();
        return $equipmentBorrowedByPlayer;
    }
        
    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $equipmentBorrowedByPlayers = array(); //Make an empty array
        $stmt = $con->prepare('SELECT equipment_borrowed_by_player.id,equipment_borrowed_by_player.equipment_id,equipment_borrowed_by_player.player_id,equipment_borrowed_by_player.amount,equipment_borrowed_by_player.borrowed_time,equipment_borrowed_by_player.due_time,equipment_borrowed_by_player.returned_time,equipment_borrowed_by_player.issue_details,player.index_number,equipment.name FROM equipment_borrowed_by_player,player,equipment WHERE equipment_borrowed_by_player.player_id=player.id AND equipment_borrowed_by_player.equipment_id=equipment.id ');
        $stmt->execute();
        $stmt->bind_result($id,$equipment_id,$player_id,$amount,$borrowedTime,$dueTime,$returnedTime,$issueDetails,$indexNumber,$equipmentName);
        while($stmt->fetch())
        {
            $equipmentBorrowedByPlayer = new EquipmentBorrowedByPlayer();
            $equipmentBorrowedByPlayer->id=$id;
            //check here k
            $equipmentBorrowedByPlayer->equipment_id=$equipment_id;
            $equipmentBorrowedByPlayer->player_id=$player_id;
            $equipmentBorrowedByPlayer->setAmount($amount);
            $equipmentBorrowedByPlayer->setBorrowedTime($borrowedTime);
            $equipmentBorrowedByPlayer->setDueTime($dueTime);
            $equipmentBorrowedByPlayer->setReturnedTime($returnedTime);
            $equipmentBorrowedByPlayer->setIssueDetails($issueDetails);
            $equipmentBorrowedByPlayer->setIndexNumber($indexNumber);
            $equipmentBorrowedByPlayer->equipmentName=$equipmentName;

            array_push($equipmentBorrowedByPlayers,$equipmentBorrowedByPlayer); //Push one by one
        }
        $stmt->close();
        
        return $equipmentBorrowedByPlayers;

    }

    public static function delete($id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('DELETE FROM equipment_borrowed_by_player WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $stmt->close();
         
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return integer
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set borrowedTime
     *
     * @param \DateTime $borrowedTime
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setBorrowedTime($borrowedTime)
    {
        $this->borrowedTime = $borrowedTime;

        return $this;
    }

    /**
     * Get borrowedTime
     *
     * @return \DateTime
     */
    public function getBorrowedTime()
    {
        return $this->borrowedTime;
    }

    /**
     * Set dueTime
     *
     * @param \DateTime $dueTime
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setDueTime($dueTime)
    {
        $this->dueTime = $dueTime;

        return $this;
    }

    /**
     * Get dueTime
     *
     * @return \DateTime
     */
    public function getDueTime()
    {
        return $this->dueTime;
    }

    /**
     * Set returnedTime
     *
     * @param \DateTime $returnedTime
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setReturnedTime($returnedTime)
    {
        $this->returnedTime = $returnedTime;

        return $this;
    }

    /**
     * Get returnedTime
     *
     * @return \DateTime
     */
    public function getReturnedTime()
    {
        return $this->returnedTime;
    }

    /**
     * Set issueDetails
     *
     * @param string $issueDetails
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setIssueDetails($issueDetails)
    {
        $this->issueDetails = $issueDetails;

        return $this;
    }

    /**
     * Get issueDetails
     *
     * @return string
     */
    public function getIssueDetails()
    {
        return $this->issueDetails;
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
     * Set player
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setPlayer(\AppBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \AppBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set equipment
     *
     * @param \AppBundle\Entity\Equipment $equipment
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setEquipment(\AppBundle\Entity\Equipment $equipment = null)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return \AppBundle\Entity\Equipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }
/*
// i added these playerid and equipmentid getters and setters
        public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;

        return $this;
    }

      public function getPlayerId()
    {
        return $this->playerId;
    }*/

}
