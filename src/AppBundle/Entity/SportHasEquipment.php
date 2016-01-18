<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;
/**
 * SportHasEquipment
 *
 * @ORM\Table(name="sport_has_equipment", indexes={@ORM\Index(name="fk_equipment_has_sport_sport1_idx", columns={"sport_id"}), @ORM\Index(name="fk_equipment_has_sport_equipment1_idx", columns={"equipment_id"}), @ORM\Index(name="fk_sport_has_equipment_authorizing_officer1_idx", columns={"authorizing_officer_id"})})
 * @ORM\Entity
 */
class SportHasEquipment
{
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
     * @var \AppBundle\Entity\Sport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sport_id", referencedColumnName="id")
     * })
     */
    private $sport;

    /**
     * @var \AppBundle\Entity\Equipment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     * })
     */
    private $equipment;

    private $equipmentId;
    private $sportId;
    private $authorizingOfficerId;

    private $equipmentName;
    private $sportName;
    private $authorizingofficerName;

    /////////////methods//////
    public function save()
    {
        if ($this->id == null)
        {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('INSERT INTO sport_has_equipment (equipment_id,sport_id,authorizing_officer_id) VALUES (?,?,?)');  
            $stmt->bind_param("iii",$this->equipmentId,$this->sportId,$this->authorizingOfficerId);  
            $stmt->execute();  
            $stmt->close();
        }
        
        else
        {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('UPDATE sport_has_equipment SET equipment_id = ? , sport_id = ?, authorizing_officer_id=? WHERE id= ?');  
            $stmt->bind_param("iiii",$this->euipmentId,$this->sportId,$this->authorizingOfficerId,$this->id);  
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


        $sportHasEquipment = new SportHasEquipment();
        $stmt = $con->prepare('SELECT sport_has_equipment.equipment_id,sport_has_equipment.sport_id,sport_has_equipment.authorizing_officer_id,equipment.name,sport.name,authorizing_officer.name FROM sport_has_equipment,equipment,sport,authorizing_officer WHERE sport_has_equipment.equipment_id = equipment.id and sport_has_equipment.sport_id = sport.id and sport_has_equipment.authorizing_officer_id = authorizing_officer.id and id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($sportHasEquipment->equipmentId,$sportHasEquipment->sportId,$sportHasEquipment->authorizingOfficerId,$sportHasEquipment->equipmentName,$sportHasEquipment->sportName,$sportHasEquipment->authorizingOfficerName);
        $stmt->fetch();
        $stmt->close();
        return $sportHasEquipment;
    }

    public static function getAll(){

        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT sport_has_equipment.id,sport_has_equipment.equipment_id,sport_has_equipment.sport_id,sport_has_equipment.authorizing_officer_id,equipment.name,sport.name,authorizing_officer.name FROM sport_has_equipment,equipment,sport,authorizing_officer WHERE sport_has_equipment.equipment_id = equipment.id and sport_has_equipment.sport_id = sport.id and sport_has_equipment.authorizing_officer_id = authorizing_officer.id');
        $stmt->execute();
        $stmt->bind_result($id,$equipmentId,$sportId,$authorizingOfficerId,$equipmentName,$sportName,$authorizingOfficerName);
        $sportHasEquipments = array();   
            while ( $stmt->fetch() ) {
            $sportHasEquipment = new SportHasEquipment();
            $sportHasEquipment->id=$id;
            $sportHasEquipment->setEquipmentId($equipmentId);
            $sportHasEquipment->setSportId($sportId);
            $sportHasEquipment->setAuthorizingOfficerId($authorizingOfficerId);
            $sportHasEquipment->setEquipmentName($equipmentName);
            $sportHasEquipment->setSportName($sportName);
            $sportHasEquipment->setAuthorizingOfficerName($authorizingOfficerName);
           
            array_push($sportHasEquipments,$sportHasEquipment);
            }
            $stmt->close();
            return $sportHasEquipments;      
        }

    public function delete($id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('DELETE FROM sport_has_equipment WHERE id=?');
        $stmt->execute();
        $stmt->close();
         
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
     * Set sport
     *
     * @param \AppBundle\Entity\Sport $sport
     *
     * @return SportHasResource
     */
    public function setSport(\AppBundle\Entity\Sport $sport = null)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get sport
     *
     * @return \AppBundle\Entity\Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set equipment
     *
     * @param \AppBundle\Entity\Equipment $equipment
     *
     * @return SportHasEquipment
     */
    public function setEquipment(\AppBundle\Entity\Equipment $equipment = null)
    {
        $this->resource = $equipment;

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

    /**
     * Set authorizingOfficer
     *
     * @param \AppBundle\Entity\AuthorizingOfficer $authorizingOfficer
     *
     * @return SportHasResource
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


//authorizing officer id
    public function setAuthorizingOfficerId($authorizingOfficerId)
    {
        $this->authorizingOfficerId = $authorizingOfficerId;

        return $this;
    }

    public function getAuthorizingOfficerId()
    {
        return $this->authorizingOfficerId;
    }  


//equipment id
    public function setEquipmentId($equipmentId)
    {
        $this->equipmentId = $equipmentId;

        return $this;
    }

     public function getEquipmentId()
    {
        return $this->equipmentId;
    } 

//sportId

    public function setSportId($sportId)
    {
        $this->sportId = $sportId;

        return $this;
    }

    public function getSportId()
    {
        return $this->sportId;
    } 

    
    //equipmentName

    public function setEquipmentName($equipmentName)
    {
        $this->equipmentName = $equipmentName;

        return $this;
    }

    public function getEquipmentName()
    {
        return $this->equipmentName;
    } 

    
    //sportName

    public function setSportName($sportName)
    {
        $this->sportName = $sportName;

        return $this;
    }

    public function getSportName()
    {
        return $this->sportName;
    } 

    //authorizingofficerName

    public function setAuthorizingOfficerName($authorizingofficerName)
    {
        $this->authorizingofficerName = $authorizingofficerName;

        return $this;
    }

    public function getAuthorizingOfficerName()
    {
        return $this->authorizingofficerName;
    } 

}