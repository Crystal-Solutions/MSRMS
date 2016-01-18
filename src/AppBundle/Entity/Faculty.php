<?php

namespace AppBundle\Entity;

use Doctrine\ORM\EntityManager;
use AppBundle\Controller\Connection;


/**
 * Faculty
 *
 * @ORM\Table(name="faculty")
 * @ORM\Entity
 */
class Faculty
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

    public function save()
    {
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('INSERT INTO Faculty (name) VALUES (?)');  
        $stmt->bind_param("s",$this->name);  
        $stmt->execute();  
        $stmt->close();

    }

    public static function getOne($id){

        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $fac = new Faculty();
        $stmt = $con->prepare('SELECT name FROM faculty WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($fac->name);
        $stmt->fetch();
        $stmt->close();
        return $fac;
    }

    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT name FROM faculty');
        $facs = array();

        if ($stmt->execute()) {
            $stmt->bind_result($name);
            
            while ( $stmt->fetch() ) {
                $fc = new Faculty();
                $fc->name = $name;
                $facs[] = $fc;
            }
            $stmt->close();
            return $facs;  
            
        }
        $stmt->close();
        return false;     
    }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Faculty
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
}
