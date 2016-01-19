<?php

namespace AppBundle\Entity;
use AppBundle\Controller\Connection;



class EquipmentReservedByPlayer
{

    
    private $start;

    private $end;

    private $amount;

    private $id;

    private $authorizingOfficer;

    private $player;

    private $equipment;

    private $authorizing_officer_id;

    private $equipment_id;

    private $player_id;

    private $eqName;

    private $playerName;

    private $authOfficerName;

    private $errorMessage;

    public function getError(){return $this->errorMessage;}

    public function validate()
    {
        $this->errorMessage = "";
        if(($this->start) > ($this->end))

            $this->errorMessage = "End date should be higher than the start date";

        return $this->errorMessage == "";
    }

    public function save()
    {
        $this->start = $this->start?$this->start->format('Y-m-d H-i-s'):null;
        $this->end = $this->end?$this->end->format('Y-m-d H-i-s'):null;
    
        if ($this->id == null) {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('INSERT INTO equipment_reserved_by_player (equipment_id,player_id,start,end,amount,authorizing_officer_id) VALUES (?,?,?,?,?,?)');  
            $stmt->bind_param("iissii",$this->equipment_id,$this->player_id,$this->start,$this->end,$this->amount,$this->authorizing_officer_id);  
            $stmt->execute();  
            $stmt->close();
        }else{
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('UPDATE equipment_reserved_by_player SET (equipment_id,player_id,start,end,amount,authorizing_officer_id) VALUES (?,?,?,?,?,?)');  
            $stmt->bind_param("iissii",$this->equipment_id,$this->player_id,$this->start,$this->end,$this->amount,$this->authorizing_officer_id);  
            $stmt->execute();  
            $stmt->close();
        }
    }

    public static function getOne($id){

        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $eq = new EquipmentReservedByPlayer();
        $eq->id = $id;

        $stmt = $con->prepare('SELECT equipment_reserved_by_player.equipment_id,equipment_reserved_by_player.player_id,equipment_reserved_by_player.start,equipment_reserved_by_player.end,equipment_reserved_by_player.amount,equipment_reserved_by_player.authorizing_officer_id,equipment.name,player.name,authorizing_officer.name FROM equipment_reserved_by_player,player,authorizing_officer,equipment WHERE equipment_reserved_by_player.equipment_id = equipment.id and equipment_reserved_by_player.player_id = player.id and equipment_reserved_by_player.authorizing_officer_id = authorizing_officer.id and equipment_reserved_by_player.equipment_id = equipment.id and equipment_reserved_by_player.id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($eq->equipment_id,$eq->player_id,$eq->start, $eq->end, $eq->amount,$eq->authorizing_officer_id,$eq->eqName,$eq->playerName,$eq->authOfficerName);
        $stmt->fetch();
        $stmt->close();
        return $eq;
    }

    public static function getAll(){
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT equipment_reserved_by_player.equipment_id,equipment_reserved_by_player.player_id,equipment_reserved_by_player.start,equipment_reserved_by_player.end,equipment_reserved_by_player.amount,equipment_reserved_by_player.authorizing_officer_id,equipment_reserved_by_player.id,equipment.name,player.name,authorizing_officer.name FROM equipment_reserved_by_player,player,authorizing_officer,equipment WHERE equipment_reserved_by_player.equipment_id = equipment.id and equipment_reserved_by_player.player_id = player.id and equipment_reserved_by_player.authorizing_officer_id = authorizing_officer.id and equipment_reserved_by_player.equipment_id = equipment.id');
        $equipment = array();

        if ($stmt->execute()) {
            $stmt->bind_result($equipment_id,$player_id,$start,$end,$amount,$authorizing_officer_id,$id,$eqName,$playerName,$authOfficerName);
            
            while ( $stmt->fetch() ) {
                $eq = new EquipmentReservedByPlayer();
                $eq->id = $id;
                /*$eq->equipment_id = $equipment_id;
                $eq->player_id = $player_id;
                $eq->start = $start;
                $eq->end = $end;
                $eq->amount = $amount;
                $eq->authorizing_officer_id = $authorizing_officer_id;
                $eq->eqName = $eqName;
                $eq->playerName = $playerName;
                $eq->authOfficerName = $authOfficerName;*/

                $eq->setEquipmentID($equipment_id);
                $eq->setPlayerID($player_id);
                $eq->setStart($start);
                $eq->setEnd($end);
                $eq->setAmount($amount);
                $eq->setAuthorizingOfficerID($authorizing_officer_id);
                $eq->setEqName($eqName);
                $eq->setPlayerName($playerName);
                $eq->setAuthOfficerName($authOfficerName);

                array_push($equipment,$eq);
            }
            $stmt->close();
            return $equipment;  
            
        }
        $stmt->close();
        return false;     
    }

    public static function delete($id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('DELETE FROM equipment_reserved_by_player WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $stmt->close();
         
    }

    /**
     * @return mixed
     */
    public function getEqName()
    {
        return $this->eqName;
    }

    /**
     * @param mixed $eqName
     */
    public function setEqName($eqName)
    {
        $this->eqName = $eqName;
    }

    /**
     * @return mixed
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
     * @param mixed $playerName
     */
    public function setPlayerName($playerName)
    {
        $this->playerName = $playerName;
    }

    /**
     * @return mixed
     */
    public function getAuthOfficerName()
    {
        return $this->authOfficerName;
    }

    /**
     * @param mixed $playerName
     */
    public function setAuthOfficerName($authOfficerName)
    {
        $this->authOfficerName = $authOfficerName;
    }

    /**
     * @return integer
     */
    public function getEquipmentID()
    {
        return $this->equipment_id;
    }

    /**
     * @param mixed $equipment_id
     */
    public function setEquipmentID($equipment_id)
    {
        $this->equipment_id = $equipment_id;
    }

    /**
     * @return integer
     */
    public function getPlayerID()
    {
        return $this->player_id;
    }

    /**
     * @param mixed $player_id
     */
    public function setPlayerID($player_id)
    {
        $this->player_id = $player_id;
    }

    /**
     * @return integer
     */
    public function getAuthorizingOfficerID()
    {
        return $this->authorizing_officer_id;
    }

    /**
     * @param mixed $authorizing_officer_id
     */
    public function setAuthorizingOfficerID($authorizing_officer_id)
    {
        $this->authorizing_officer_id = $authorizing_officer_id;
    }

    /**
     * Set start
     *
     * @param \DateTime $start
     *
     * @return EquipmentReservedByPlayer
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get start
     *
     * @return \DateTime
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set end
     *
     * @param \DateTime $end
     *
     * @return EquipmentReservedByPlayer
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get end
     *
     * @return \DateTime
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return EquipmentReservedByPlayer
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set authorizingOfficer
     *
     * @param \AppBundle\Entity\AuthorizingOfficer $authorizingOfficer
     *
     * @return EquipmentReservedByPlayer
     */
    public function setAuthorizingOfficer(\AppBundle\Entity\AuthorizingOfficer $authorizingOfficer = null)
    {
        $this->authorizingOfficer = $authorizingOfficer;

        return $this;
    }

    /**
     * Get authorizingOfficer
     *
     * @return \AppBundle\Entity\AuthorizingOfficer
     */
    public function getAuthorizingOfficer()
    {
        return $this->authorizingOfficer;
    }

    /**
     * Set player
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return EquipmentReservedByPlayer
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
     * @return EquipmentReservedByPlayer
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
}
