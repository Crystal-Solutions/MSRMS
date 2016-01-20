<?php

namespace AppBundle\Entity;

use AppBundle\Controller\Connection;


class Equipment
{

    private $name;


    private $description;


    private $amount;
    public $returnedTime;

    public $id;

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
        $stmt = $con->prepare('UPDATE equipment SET name =?,description=?,amount=? WHERE id=?');  
        $stmt->bind_param("ssii",$this->name,$this->description,$this->amount,$this->id);    
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
            die("Failed to connect to MySQL: " . mysqli_connect_error());
        }

        $equipment = new Equipment();
        $stmt = $con->prepare('SELECT id,name,description,amount FROM equipment WHERE equipment.id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($equipment->id,$equipment->name,$equipment->description,$equipment->amount);
        $stmt->fetch();
        $stmt->close();
        return $equipment;
    }
        public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

         $equipments = array(); //Make an empty array
        $stmt = $con->prepare('SELECT id,name,description,amount FROM equipment');
        $stmt->execute();
        $stmt->bind_result($id,$name,$description,$amount);
        while($stmt->fetch())
        {
            $equipment = new Equipment();
            $equipment->id=$id;
            $equipment->setName($name);
            $equipment->setDescription($description);
            $equipment->setAmount($amount);
           

            array_push($equipments,$equipment); //Push one by one
        }
        $stmt->close();
        
        return $equipments;

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

    public function getAvailableAmount()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $borrowedAmount = 0;
        $reservedAmount = 0;
        $stmt = $con->prepare('SELECT SUM(amount) FROM equipment_borrowed_by_player WHERE equipment_id=? AND  returned_time is NULL ;');
        $stmt->bind_param("s",$this->id); $stmt->execute();
        $stmt->bind_result($borrowedAmount);
        $stmt->fetch();
        $stmt->close();

        $stmt2 = $con->prepare('SELECT SUM(amount) FROM equipment_reserved_by_player WHERE equipment_id=?  ;');
        $stmt2->bind_param("s",$this->id); $stmt2->execute();
        $stmt2->bind_result($reservedAmount);
        $stmt2->fetch();
        $stmt2->close();


        return $this->amount - ($borrowedAmount+$reservedAmount);
    }
}
