<?php

namespace AppBundle\Entity;

use AppBundle\Controller\Connection;


class Department
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    
    private $id;

    /**
     * @var \AppBundle\Entity\Faculty
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Faculty")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="faculty_id", referencedColumnName="id")
     * })
     */
    private $faculty;

    public $faculty_id;

    public function save()
    {
        if ($this->id == null)
        {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('INSERT INTO Department (name,faculty_id) VALUES (?,?)');  
            $stmt->bind_param("si",$this->name,$this->faculty_id);  
            $stmt->execute();  
            $stmt->close();
        }
        
        else
        {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('UPDATE Department SET name = ? , faculty_id = ? WHERE name = ?');  
            $stmt->bind_param("sii",$this->name,$this->faculty_id,$this->name);  
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

        $dept = new Department();
        $stmt = $con->prepare('SELECT name,faculty_id FROM department WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($dept->name,$dept->faculty_id);
        $stmt->fetch();
        $stmt->close();
        return $dept;
    }

    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT id,name,faculty_id FROM department');
        $depts = array();

        if ($stmt->execute()) {
            $stmt->bind_result($id,$name,$faculty_id);
            
            while ( $stmt->fetch() ) {
                $dp = new Department();
                $dp->name = $name;
                $dp->faculty_id = $faculty_id;
                $dp->id = $id;
                $depts[] = $dp;
            }
            $stmt->close();
            return $depts;  
            
        }
        $stmt->close();
        return false;     
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Department
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

    
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set faculty
     *
     * @param \AppBundle\Entity\Faculty $faculty
     *
     * @return Department
     */
    public function setFaculty(\AppBundle\Entity\Faculty $faculty = null)
    {
        $this->faculty = $faculty;

        return $this;
    }

    /**
     * Get faculty
     *
     * @return \AppBundle\Entity\Faculty
     */
    public function getFaculty()
    {
        return $this->faculty;
    }
}
