<?php

namespace AppBundle\Entity;

use AppBundle\Controller\Connection;


    class Sport
    {

    private $name;


    private $description;


    public $id;

    public function save()
    {
        if ($this->id == null)
        {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('INSERT INTO Sport (name,description) VALUES (?,?)');  
            $stmt->bind_param("ss",$this->name,$this->description);  
            $stmt->execute();  
            $stmt->close();
        }
        
        else
        {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('UPDATE Sport SET name = ? , description = ? WHERE name = ?');  
            $stmt->bind_param("sii",$this->name,$this->description,$this->name);  
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

        $sport = new Sport();
        $stmt = $con->prepare('SELECT name,description FROM sport WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($sport->name,$sport->description);
        $stmt->fetch();
        $stmt->close();
        return $sport;
    }

    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT id,name,description FROM sport');
        $sports = array();

        if ($stmt->execute()) {
            $stmt->bind_result($id,$name,$sport);
            
            while ( $stmt->fetch() ) {
                $sprt = new Sport();
                $sprt->id=$id;
                $sprt->name = $name;
                $sprt->description = $sport;
                $sports[] = $sprt;
            }
            $stmt->close();
            return $sports;  
            
        }
        $stmt->close();
        return false;     
    }




    /**
     * Set name
     *
     * @param string $name
     *
     * @return Sport
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
     * @return Sport
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

}
