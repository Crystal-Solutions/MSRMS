<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
    public $equipment_id;
    public $sport_id;
    public $authorizing_officer_id;

    public function save()
    {
        if ($this->id == null) {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('INSERT INTO sport_has_equipment (equipment_id,sport_id,authorizing_officer_id) VALUES (?,?,?)');  
            $stmt->bind_param("sss",$this->equipment_id,$this->sport_id,$this->authorizing_officer_id);
            $stmt->execute();  
            $stmt->close();
        }else{
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('UPDATE sport_has_equipment SET (equipment_id,sport_id,authorizing_officer_id) VALUES (?,?,?)');
            $stmt->bind_param("sss",$this->equipment_id,$this->sport_id,$this->authorizing_officer_id);
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

        $eq = new SportHasEquipment();
        $eq->id = $id;

        $stmt = $con->prepare('SELECT equipment_id,sport_id,authorizing_officer_id FROM sport_has_equipment WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($eq->equipment_id,$eq->sport_id,$eq->authorizing_officer_id);
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

        $stmt = $con->prepare('SELECT equipment_id,sport_id,authorizing_officer_id,id FROM equipment_reserved_by_player');
        $equipment = array();

        if ($stmt->execute()) {
            $stmt->bind_result($equipment_id,$sport_id,$authorizing_officer_id,$id);
            
            while ( $stmt->fetch() ) {
                $eq = new SportHasEquipment();
                $eq->id = $id;
                $eq->equipment_id = $equipment_id;
                $eq->sport_id = $sport_id;
                $eq->authorizing_officer_id = $authorizing_officer_id;
                $equipment[] = $eq;
            }
            $stmt->close();
            return $equipment;  
        }
        $stmt->close();
        return false;     
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
}
