<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipment
 *
 * @ORM\Table(name="equipment")
 * @ORM\Entity
 */
class Equipment
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=450, nullable=true)
     */
    private $description;

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

    public function save()
    {

      

        if($this->id ==null)
        {
           
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('INSERT INTO `equipment` (`name`, `description`, `amount`) VALUES (?,?,?)');  
        $stmt->bind_param("ssi",$this->name,$this->description,$this->amount);  
        $stmt->execute();  
        $stmt->close();
        }
        else
        {
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('UPDATE player SET name =?,description=?,amount=? WHERE equipment.id = id');  
        $stmt->bind_param("ssi",$this->name,$this->description,$this->amount);    
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

        $player = new Player();
        $stmt = $con->prepare('SELECT name,year,date_of_birth,address,blood_type,department_id FROM player WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($player->name,$player->year,$player->date_of_birth,$player->address,$player->blood_type,$player->department_id);
        $stmt->fetch();
        $stmt->close();
        return $player;
    }
        public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

         $players = array(); //Make an empty array
        $stmt = $con->prepare('SELECT name,year,date_of_birth,address,blood_type,department_id FROM player');
        $stmt->execute();
        $stmt->bind_result($name,$year,$dateOfBirth,$address,$bloodType,$departmentId);
        while($stmt->fetch())
        {
            $player = new Player();
            $player->setName($name);
            $player->setYear($year);
            $player->setDateOfBirth($dateOfBirth);
            $player->setAddress($address);
            $player->setBloodType($bloodType);
            $player->setDepartmentId($departmentId);

            array_push($players,$player); //Push one by one
        }
        $stmt->close();
        
        return $players;

    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Equipment
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Equipment
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
     * Set amount
     *
     * @param integer $amount
     *
     * @return Equipment
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
}
