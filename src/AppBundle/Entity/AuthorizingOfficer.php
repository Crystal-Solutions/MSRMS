<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;
use Symfony\Component\Security\Core\User\UserInterface;



/**
 * AuthorizingOfficer
 *
 * @ORM\Table(name="authorizing_officer")
 * @ORM\Entity
 */
class AuthorizingOfficer implements UserInterface, \Serializable
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


    //Newly added - Getters and setter are just below
    /**
     * @ORM\Column(name="username", type="string", length=25, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(name="password",type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(name="email", type="string")
     */
    private $email;

    /**
     * @ORM\Column(name="is_active", type="string")
     */
    private $isActive;


    //For authentication purpose-----------------------------------------------
    public function __construct()
    {
        $this->isActive = true;
        // may not be needed, see section on salt below
        // $this->salt = md5(uniqid(null, true));
    }
    public function getSalt()
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles()
    {
        return array('ROLE_ADMIN');
    }

    public function eraseCredentials()
    {
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->name,
            $this->email,

            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->name,
            $this->email,
            // see section on salt below
            // $this->salt
            ) = unserialize($serialized);
    }
    //-------------------------------------------------------------------------

//---------------------validate function ------------------------under construction
 private $errorMessage;
    
    public function getError(){ return $this->errorMessage;}

    public function validate()
    {
        $this->errorMessage = "";
        if ( ( (!preg_match("/([\d]{10})/", $this->contactNu)) && strlen($this->contactNu)!=10 ) )
            $this->errorMessage = "Contact Number is not valid";

       $authOfficers = AuthorizingOfficer::getAll();
       $userNames= array();
       foreach ($authOfficers as $auth){
         array_push($userNames,$auth->getUserName());
         }

       if (in_array($this->username,$userNames)) $this->errorMessage= 'username already assigned';
 
       if (  strlen($this->password)<6 )
            $this->errorMessage = "Password must be atleast 6 characters long";

       
    /*    $bloodTypes = array('A+','A-','B+', 'B-', 'AB+', 'AB-', 'O+', 'O-');
        if(!in_array($this->bloodType, $bloodTypes))
            $this->errorMessage = 'Blood Type is not valid'; */

        //Return true if error message is "" (no eror)
        //Else return false
        return $this->errorMessage == "";
    }
 //-----------------------------------------------------------   


    public function save()
    {
        if ($this->id == null) {
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('INSERT INTO authorizing_officer (name,contact_nu, username,password, email,is_active) VALUES (?,?,?,?,?,?)');
            $stmt->bind_param("ssssss",$this->name,$this->contactNu, $this->username, $this-> password, $this->email, $this->isActive);
            $stmt->execute();  
            $stmt->close();
        }else{
            $con = Connection::getConnectionObject()->getConnection();
            $stmt = $con->prepare('UPDATE authorizing_officer SET (name,contact_nu, username,password, email,is_active) VALUES (?,?,?,?,?,?)');
            $stmt->bind_param("ssssss",$this->name,$this->contactNu, $this->username, $this-> password, $this->email, $this->isActive);
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

        $stmt = $con->prepare('SELECT name,contact_nu,username,password,email,is_active FROM authorizing_officer WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($au->name, $au->contactNu,  $au->username, $au-> password, $au->email, $au->isActive);
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

        $stmt = $con->prepare('SELECT id,name,contact_nu,username,password,email,is_active FROM authorizing_officer');
        $officers = array();

        if ($stmt->execute()) {
            $stmt->bind_result($id,$name,$number,$username,$password,$email,$isActive);
            
            while ( $stmt->fetch() ) {
                $au = new AuthorizingOfficer();
                $au->id = $id;
                $au->name = $name;
                $au->contactNu = $number;
                $au->username = $username;
                $au->password = $password;
                $au->email = $email;
                $au->isActive = $isActive;
                $officers[] = $au;
            }
            $stmt->close();
            return $officers;  
            
        }
        $stmt->close();
        return false;     
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



    /**
     * @return mixed
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }


    //The value which will be save is 1.. but we access as true or false;
    /**
     * @return mixed
     */
    public function getIsActive()
    {
        return ($this->isActive=='1');
    }

    /**
     * @param mixed $isActive
     */
    public function setIsActive($isActive)
    {
        if($isActive)
            $this->isActive = 1;
        else
            $this->isActive = 0;
    }



}
