<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;
use AppBundle\Entity\Resource;

/**
 * Resource
 *
 * @ORM\Table(name="resource")
 * @ORM\Entity
 */
class Resource
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=450, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="instructor_name", type="string", length=128, nullable=true)
     */
    private $instructorName;

    /**
     * @var string
     *
     * @ORM\Column(name="location", type="string", length=128, nullable=true)
     */
    private $location;

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
        if ($this->id == null) {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('INSERT INTO resource (name,description,instructor_name,location) VALUES (?,?,?,?)');  
            $stmt->bind_param("ssss",$this->name,$this->description,$this->instructorName,$this->location);  
            $stmt->execute();  
            $stmt->close();
        }else{
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('UPDATE resource SET (name,description,instructor_name,location) VALUES (?,?,?,?)');  
            $stmt->bind_param("ssss",$this->name,$this->description,$this->instructorName,$this->location);  
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

        $res = new Resource();
        $res->id = $id;

        $stmt = $con->prepare('SELECT name,description,instructor_name,location FROM resource WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($res->name, $res->description,$res->instructorName,$res->location );
        $stmt->fetch();
        $stmt->close();
        return $res;
    }

    public static function getAll(){
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT id,name,description,instructor_name,location FROM resource');
        $rss = array();

        if ($stmt->execute()) {
            $stmt->bind_result($id,$name,$description,$instructor_name,$location);
            
            while ( $stmt->fetch() ) {
                $res = new Resource();
                $res->id = $id;
                $res->name = $name;
                $res->description = $description;
                $res->instructorName = $instructor_name;
                $res->location = $location;
                $rss[] = $res;
            }
            $stmt->close();
            return $rss;  
            
        }
        $stmt->close();
        return false;     
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Resource
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
     * @return Resource
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
     * Set instructorName
     *
     * @param string $instructorName
     *
     * @return Resource
     */
    public function setInstructorName($instructorName)
    {
        $this->instructorName = $instructorName;

        return $this;
    }

    /**
     * Get instructorName
     *
     * @return string
     */
    public function getInstructorName()
    {
        return $this->instructorName;
    }

    /**
     * Set location
     *
     * @param string $location
     *
     * @return Resource
     */
    public function setLocation($location)
    {
        $this->location = $location;

        return $this;
    }

    /**
     * Get location
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->location;
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
