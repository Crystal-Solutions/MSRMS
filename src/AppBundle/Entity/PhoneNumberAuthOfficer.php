<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;

/**
 * PhoneNumberAuthOfficer
 *
 * @ORM\Table(name="phone_number_auth_officer", indexes={@ORM\Index(name="fk_phone_number_auth_officer_authorizing_officer1_idx", columns={"authorizing_officer_id"})})
 * @ORM\Entity
 */
class PhoneNumberAuthOfficer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $number;

    /**
     * @var \AppBundle\Entity\AuthorizingOfficer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AuthorizingOfficer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="authorizing_officer_id", referencedColumnName="id")
     * })
     */
    private $authorizingOfficer;

    private $authorizingOfficerId;


 public function save()
    {

   
        if($this->authorizingOfficerId ==null)
        {
           
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('INSERT INTO `phone_number_auth_officer` (`number`,`authorizing_officer_id`) VALUES (?,?)');  
        $stmt->bind_param("ii",$this->number,$this->authorizingOfficerId);  
        $stmt->execute();  
        $stmt->close();
        }
        else
        {
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('UPDATE phone_number_auth_officer SET `number` =?,authorizing_officer_id=? WHERE id=?');  
        $stmt->bind_param("iii",$this->number,$this->authorizingOfficerId,$this->id);  
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

        $phoneNumberAuthOfficer = new PhoneNumberAuthOfficer();
        $stmt = $con->prepare('SELECT id,`number`,authorizing_officer_id FROM phone_number_auth_officer WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($phoneNumberAuthOfficer->id,$phoneNumberAuthOfficer->number,$phoneNumberAuthOfficer->authorizingOfficerId);
        $stmt->fetch();
        $stmt->close();
        return $phoneNumberAuthOfficer;
    }


    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $phoneNumberAuthOfficers = array(); //Make an empty array - don't mind the name
        $stmt = $con->prepare('SELECT id,`number`,authorizing_officer_id FROM phone_number_auth_officer');
        $stmt->execute();
        $stmt->bind_result($id,$number,$authorizingOfficerId);
        while($stmt->fetch())
        {
            $phoneNumberAuthOfficer = new PhoneNumberAuthOfficer();
            $phoneNumberAuthOfficer->id=$id;
            //check here k
            //there is no setNumber functio ?? what to do, check
            $phoneNumberAuthOfficer->setPlayerId($playerId);
            $phoneNumberAuthOfficer->setSportId($sportId);
          
     

            array_push($playerInvolvedInSports,$playerInvolvedInSport); //Push one by one
        }
        $stmt->close();
        
        return $playerInvolvedInSports;

    }


    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }


    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set authorizingOfficer
     *
     * @param \AppBundle\Entity\AuthorizingOfficer $authorizingOfficer
     *
     * @return PhoneNumberAuthOfficer
     */
    public function setAuthorizingOfficer(\AppBundle\Entity\AuthorizingOfficer $authorizingOfficer = null)
    {
        $this->authorizingOfficer = $authorizingOfficer;

        return $this;
    }

    /**
     * Get authorizingOfficer
     *
     * @return \AppBundle\Entity\AuthorizingOfficer
     */
    public function getAuthorizingOfficer()
    {
        return $this->authorizingOfficer;
    }


    public function setAuthorizingOfficerId($authorizingOfficerId)
    {
        $this->authorizingOfficerId = $authorizingOfficerId;

        return $this;
    }

    public function getAuthorizingOfficerId()
    {
        return $this->authorizingOfficerId;
    }  
}
