<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;


class Player
{

    private $name;


    private $year;


    private $dateOfBirth;


    private $address;


    private $bloodType;



    private $id;

  
    private $department;

    //Manually added
    public $departmentId;

    public function save()
    {

        $this->dateOfBirth = $this->dateOfBirth->format('Y-m-d');

        if($this->id ==null)
        {
           
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('INSERT INTO `player` (`name`, `date_of_birth`, `year`, `department_id`, `address`, `blood_type`) VALUES (?,?,?,?,?,?)');  
        $stmt->bind_param("ssiiss",$this->name,$this->dateOfBirth,$this->year,$this->departmentId,$this->address,$this->bloodType);  
        $stmt->execute();  
        $stmt->close();
        }
        else
        {
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('UPDATE player SET name =?,date_of_birth=?,year=?,department_id=?,address=?,blood_type=? WHERE player.id = id');  
        $stmt->bind_param("ssiiss",$this->name,$this->dateOfBirth,$this->year,$this->departmentId,$this->address,$this->bloodType);  
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
     * @return Player
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
     * Set year
     *
     * @param integer $year
     *
     * @return Player
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Player
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Player
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set bloodType
     *
     * @param string $bloodType
     *
     * @return Player
     */
    public function setBloodType($bloodType)
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    /**
     * Get bloodType
     *
     * @return string
     */
    public function getBloodType()
    {
        return $this->bloodType;
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
     * Set department
     *
     * @param \AppBundle\Entity\Department $department
     *
     * @return Player
     */
    public function setDepartment(\AppBundle\Entity\Department $department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \AppBundle\Entity\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

        public function setDepartmentId($departmentId)
    {
        $this->departmentId = $departmentId;

        return $this;
    }

    /**
     * Get bloodType
     *
     * @return string
     */
    public function getDepartmentId()
    {
        return $this->departmentId;
    }

}
