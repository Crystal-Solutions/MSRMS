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
        if($this->id ==null)
        {
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('INSERT INTO `player` (`name`, `date_of_birth`, `year`, `department_id`, `address`, `blood_type`) VALUES (?,?,?,?,?,?)');  
        $stmt->bind_param("ssiiss",$this->name,$this->date_of_birth,$this->year,$this->departmentId,$this->address,$this->blood_type);  
        $stmt->execute();  
        $stmt->close();
        }
        else
        {
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('UPDATE player SET name =?,date_of_birth=?,year=?,department_id=?,address=?,blood_type=? WHERE player.id = id');  
        $stmt->bind_param("ssiiss",$this->name,$this->date_of_birth,$this->year,$this->departmentId,$this->address,$this->blood_type);  
        $stmt->execute();  
        $stmt->close();   
        }
    }

    public static function getOne($id)
    {
        $player = new Player();
        $player->setName($name=$con->prepare('SELECT name FROM player WHERE player.id=id'));
        $player->setYear($year=$con->prepare('SELECT year FROM player WHERE player.id=id'));
        $player->setDateOfBirth($date_of_birth=$con->prepare('SELECT datae_of_birth FROM player WHERE player.id=id'));
        $player->setAddress($address=$con->prepare('SELECT address FROM player WHERE player.id=id'));
        $player->setYear($year=$con->prepare('SELECT year FROM player WHERE player.id=id'));
        $player->setBloodType($blood_type=$con->prepare('SELECT blood_type FROM player WHERE player.id=id'));
        $player->departmentId=$departmentId;
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
}
