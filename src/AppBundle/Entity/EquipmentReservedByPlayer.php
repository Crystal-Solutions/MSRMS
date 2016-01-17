<?php

namespace AppBundle\Entity;
use AppBundle\Controller\Connection;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipmentReservedByPlayer
 *
 * @ORM\Table(name="equipment_reserved_by_player", indexes={@ORM\Index(name="fk_equipment_has_player_player1_idx", columns={"player_id"}), @ORM\Index(name="fk_equipment_has_player_equipment1_idx", columns={"equipment_id"}), @ORM\Index(name="fk_equipment_reserved_by_player_authorizing_officer1_idx", columns={"authorizing_officer_id"})})
 * @ORM\Entity
 */
class EquipmentReservedByPlayer
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start", type="datetime", nullable=true)
     */
    private $start;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end", type="datetime", nullable=true)
     */
    private $end;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\AuthorizingOfficer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AuthorizingOfficer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="authorizing_officer_id", referencedColumnName="id")
     * })
     */
    private $authorizingOfficer;

    /**
     * @var \AppBundle\Entity\Player
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * })
     */
    private $player;

    /**
     * @var \AppBundle\Entity\Equipment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     * })
     */
    private $equipment;

    public $authorizing_officer_id;

    public $equipment_id;

    public $player_id;

    public $eqName;

    public $playerName;

    public $authOfficerName;

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
                $eq->equipment_id = $equipment_id;
                $eq->player_id = $player_id;
                $eq->start = $start;
                $eq->end = $end;
                $eq->amount = $amount;
                $eq->authorizing_officer_id = $authorizing_officer_id;
                $eq->eqName = $eqName;
                $eq->playerName = $playerName;
                $eq->authOfficerName = $authOfficerName;
                array_push($equipment,$eq);
            }
            $stmt->close();
            return $equipment;  
            
        }
        $stmt->close();
        return false;     
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
