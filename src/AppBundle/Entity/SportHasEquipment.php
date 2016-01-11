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
            $stmt = $con->prepare('UPDATE sport_has_equipment SET equipment_id = ? , sport_id = ? WHERE authorizing_officer_id= ?');  
            $stmt->bind_param("iii",$this->euipmentId,$this->sportId,$this->authorizingOfficerId);  
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

        $sportHasEquipment = new SportHasEquipment();
        $stmt = $con->prepare('SELECT equipment_id,sport_id,authorizing_officer_id FROM sport_has_equipment WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($sportHasEquipment->equipmentId,$sportHasEquipment->sportId,$sportHasEquipment->authorizingOfficerId);
        $stmt->fetch();
        $stmt->close();
        return $sportHasEquipment;
    }

    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT id,equipment_id,sport_id,authorizing_officer_id FROM sport_has_equipment');
        $stmt->execute();
        $stmt->bind_result($id,$equipmentId,$sportId,$authorizingOfficerId);
        $sportHasEquipments = array();   
            while ( $stmt->fetch() ) {
            $sportHasEquipment = new SportHasEquipment();
            $sportHasEquipment->id=$id;
            $sportHasEquipment->setEquipmentId($equipmentId);
            $sportHasEquipment->setSportId($sportId);
            $sportHasEquipment->setAuthorizingOfficerId($authorizingOfficerId);
           

            array_push($sportHasEquipments,$sportHasEquipment);
            }
            $stmt->close();
            return $sportHasEquipments;      
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
     * @return SportHasEquipment
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
     * Set sport
     *
     * @param \AppBundle\Entity\Sport $sport
     *
     * @return SportHasEquipment
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

// manually added methods from here on
    public function setEquipmentId($equipmentId)
    {
        $this->equipmentId = $equipmentId;

        return $this;
    }


    public function getEquipmentId()
    {
        return $this->equipmentId;
    }
///////////////////////////////////////////////////
    public function setSportId($sportId)
    {
        $this->sportId = $sportId;

        return $this;
    }


    public function getSportId()
    {
        return $this->sportId;
    }

///////////////////////////////////////////////////
    public function setAuthorizingOfficerId($authorizingOfficerId)
    {
        $this->authorizingOfficerId = $authorizingOfficerId;

        return $this;
    }


    public function getAuthorizingOfficerId()
    {
        return $this->authorizingOfficerId;
    }
}
