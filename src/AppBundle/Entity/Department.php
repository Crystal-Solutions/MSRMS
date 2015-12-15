<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;

/**
 * Department
 *
 * @ORM\Table(name="department", indexes={@ORM\Index(name="fk_department_faculty1_idx", columns={"faculty_id"})})
 * @ORM\Entity
 */
class Department
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
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

    public static getDepartment($id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
          {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }

        $sql="SELECT Lastname,Age FROM Persons ORDER BY Lastname";

        if ($result=mysqli_query($con,$sql))
          {
          while ($obj=mysqli_fetch_object($result))
            {
            printf("%s (%s)\n",$obj->Lastname,$obj->Age);
            }
          // Free result set
          mysqli_free_result($result);
        }

        mysqli_close($con);

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
