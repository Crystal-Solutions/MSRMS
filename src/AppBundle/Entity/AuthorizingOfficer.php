<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;
use AppBundle\Entity\AuthorizingOfficer;

/**
 * AuthorizingOfficer
 *
 * @ORM\Table(name="authorizing_officer")
 * @ORM\Entity
 */
class AuthorizingOfficer
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_nu", type="string", length=45, nullable=true)
     */
    private $contactNu;

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
            $stmt = $con->prepare('INSERT INTO authorizing_officer (name,contact_nu) VALUES (?,?)');  
            $stmt->bind_param("ss",$this->name,$this->contactNu);  
            $stmt->execute();  
            $stmt->close();
        }else{
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('UPDATE authorizing_officer SET (name,contact_nu) VALUES (?,?)');  
            $stmt->bind_param("ss",$this->name,$this->contactNu);  
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

        $au = new AuthorizingOfficer();
        $au->id = $id;

        $stmt = $con->prepare('SELECT name,contact_nu FROM authorizing_officer WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($au->name, $au->contactNu );
        $stmt->fetch();
        $stmt->close();
        return $au;
    }

    public static function getAll(){
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $officers = array(); //Make an empty array
        $stmt = $con->prepare('SELECT name,contact_nu FROM authorizing_officer');
        $stmt->execute();
        $stmt->bind_result($name,$contactNu);
		while($stmt->fetch())
		{
			$off = new AuthorizingOfficer();
			$off->setName($name);
			$off->setContactNu($contactNu);
			array_push($officers,$off); //Push one by one
		}
        $stmt->close();
		
        return $officers;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return AuthorizingOfficer
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
     * Set contactNu
     *
     * @param string $contactNu
     *
     * @return AuthorizingOfficer
     */
    public function setContactNu($contactNu)
    {
        $this->contactNu = $contactNu;

        return $this;
    }

    /**
     * Get contactNu
     *
     * @return string
     */
    public function getContactNu()
    {
        return $this->contactNu;
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
