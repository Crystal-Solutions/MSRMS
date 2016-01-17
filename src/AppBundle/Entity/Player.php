<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;
use Symfony\Component\Validator\Constraints\DateTime;

class Player
{

    private $name;

    private $indexNumber;


    private $year;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_of_birth", type="date", nullable=true)
     */
    private $dateOfBirth;


    private $address;


    private $bloodType;



    private $id;

  
    private $department;

    //Manually added
    public $departmentId;


    //Generated Attributes
    private $departmentName;
    private $facultyName;

    //-----------Validation related stuff------------------------------------------------------
    private $errorMessage;
    
    public function getError(){ return $this->errorMessage;}

    public function validate()
    {
        $this->errorMessage = "";
        if ( ( (!preg_match("/([\d]{6})(([A-Z])|([a-z]))/", $this->indexNumber)) && strlen($this->indexNumber)!=7 ) )
            $this->errorMessage = "Index number is not valid";
        if($this->year<0 || $this->year>6)
            $this->errorMessage = "Year is not valid.";

        if(strtotime($this->dateOfBirth->format('Y-m-d')) > strtotime("-18 YEAR") || strtotime($this->dateOfBirth->format('Y-m-d')) < strtotime("-120 YEAR"))
            $this->errorMessage = "Date of Birth is not valid";

       
        $bloodTypes = array('A+','A-','B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
        if(!in_array($this->bloodType, $bloodTypes))
            $this->errorMessage = 'Blood Type is not valid';

        //Return true if error message is "" (no eror)
        //Else return false
        return $this->errorMessage == "";
    }
    //--------------------------------------------------------------------------------------------


    public function save()
    {

        $this->dateOfBirth = $this->dateOfBirth->format('Y-m-d');

        if($this->id ==null)
        {
           
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('INSERT INTO `player` (`name`,`index_number`, `date_of_birth`, `year`, `department_id`, `address`, `blood_type`) VALUES (?,?,   ?,?,?,?,?)');  
        $stmt->bind_param("sssiiss",$this->name,$this->indexNumber,$this->dateOfBirth,$this->year,$this->departmentId,$this->address,$this->bloodType);  
        $stmt->execute();  
        $stmt->close();
        }
        else
        {
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('UPDATE player SET name =?,index_number=?,date_of_birth=?,year=?,department_id=?,address=?,blood_type=? WHERE player.id = id');  
        $stmt->bind_param("sssiiss",$this->name,$this->indexNumber,$this->dateOfBirth,$this->year,$this->departmentId,$this->address,$this->bloodType);  
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
        $stmt = $con->prepare('SELECT player.id, player.name, player.index_number, player.year, player.date_of_birth, player.address, player.blood_type, player.department_id, department.name, faculty.name FROM player,department,faculty where player.id=department.id and faculty.id=department.faculty_id and player.id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($player->id,$player->name,$player->indexNumber,$player->year,$player->dateOfBirth,$player->address,$player->bloodType,$player->departmentId, $player->departmentName, $player->facultyName);
        $stmt->fetch();

        //sending a DateTime object to the form
        $player->setDateOfBirth(new \DateTime($player->getDateOfBirth()));
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
        $stmt = $con->prepare('SELECT player.id, player.name, player.index_number, player.year, player.date_of_birth, player.address, player.blood_type, player.department_id, department.name, faculty.name FROM player,department,faculty where player.department_id=department.id and faculty.id=department.faculty_id');
        $stmt->execute();
        $stmt->bind_result($id,$name,$indexNumber,$year,$dateOfBirth,$address,$bloodType,$departmentId,$departmentName, $facultyName);
        while($stmt->fetch())
        {
            $player = new Player();
            $player->id=$id;
            $player->setName($name);
            $player->setIndexNumber($indexNumber);
            $player->setYear($year);
            $player->setDateOfBirth($dateOfBirth);
            $player->setAddress($address);
            $player->setBloodType($bloodType);
            $player->setDepartmentId($departmentId);
            $player->setDepartmentName($departmentName);
            $player->setFacultyName($facultyName);

            //sending a DateTime object to the form
            $player->setDateOfBirth(new \DateTime($player->getDateOfBirth()));

            array_push($players,$player); //Push one by one
        }
        $stmt->close();
        
        return $players;

    }

    /**
     * @return mixed
     */
    public function getDepartmentName()
    {
        return $this->departmentName;
    }

    /**
     * @param mixed $departmentName
     */
    public function setDepartmentName($departmentName)
    {
        $this->departmentName = $departmentName;
    }

    /**
     * @return mixed
     */
    public function getFacultyName()
    {
        return $this->facultyName;
    }

    /**
     * @param mixed $facultyName
     */
    public function setFacultyName($facultyName)
    {
        $this->facultyName = $facultyName;
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
     * Set indexNumber
     *
     * @param string $indexNumber
     *
     * @return Player
     */
          public function setIndexNumber($indexNumber)
    {
        $this->indexNumber = $indexNumber;

        return $this;
    }

    /**
     * Get indexNumber
     *
     * @return string
     */
    public function getIndexNumber()
    {
        return $this->indexNumber;
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
     * Get departmentId
     *
     * @return string
     */
    public function getDepartmentId()
    {
        return $this->departmentId;
    }

}


