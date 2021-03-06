<?php

namespace AppBundle\Entity;

use AppBundle\Controller\Connection;

class SportHasResource
{
   
    private $id;

    
    private $sport;

    private $resource;

   
    private $authorizingOfficer;

    private $authorizingOfficerId;

    private $resourceId;

    private $sportId;

    public $authorizingOfficerName;

    public $resourceName;

    public $sportName;

    public function save()
    {
        if($this->id ==null)
        {
           
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('INSERT INTO `sport_has_resource` (`sport_id`,`resource_id`,`authorizing_officer_id`) VALUES (?,?,?)');  
        $stmt->bind_param("iii",$this->sportId,$this->resourceId,$this->authorizingOfficerId);  
        $stmt->execute();  
        $stmt->close();
        }
        else
        {
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('UPDATE sport_has_resource SET sport_id =?,resource_id=?,authorizing_officer_id=? WHERE id=?');  
        $stmt->bind_param("iiii",$this->sportId,$this->resourceId,$this->authorizingOfficerId,$this->id);  
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

        $sportHasResource = new SportHasResource();
        $stmt = $con->prepare('SELECT sport_has_resource.id,sport_has_resource.sport_id,sport_has_resource.resource_id,sport_has_resource.authorizing_officer_id,sport.name,resource.name,authorizing_officer.name FROM sport_has_resource,sport,resource,authorizing_officer WHERE sport_has_resource.sport_id = sport.id and sport_has_resource.resource_id = resource.id and sport_has_resource.authorizing_officer_id = authorizing_officer.id and sport_has_resource.id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($sportHasResource->id,$sportHasResource->sportId,$sportHasResource->resourceId,$sportHasResource->authorizingOfficerId,$sportHasResource->sportName,$sportHasResource->resourceName,$sportHasResource->authorizingOfficerName);
        $stmt->fetch();
        $stmt->close();
        return $sportHasResource;
    }


   public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $sportHasResources = array(); //Make an empty array - don't mind the name
        $stmt = $con->prepare('SELECT sport_has_resource.id,sport_has_resource.sport_id,sport_has_resource.resource_id,sport_has_resource.authorizing_officer_id,sport.name,resource.name,authorizing_officer.name FROM sport_has_resource,sport,resource,authorizing_officer WHERE sport_has_resource.sport_id = sport.id and sport_has_resource.resource_id = resource.id and sport_has_resource.authorizing_officer_id = authorizing_officer.id');
        $stmt->execute();
        $stmt->bind_result($id,$sportId,$resourceId,$authorizingOfficerId,$sportName,$resourceName,$authorizingOfficerName);
        while($stmt->fetch())
        {
            $sportHasResource = new SportHasResource ();
            $sportHasResource ->id=$id;
            //check here k
            $sportHasResource ->setSportId($sportId);
            $sportHasResource ->setResourceId($resourceId);
            $sportHasResource ->setAuthorizingOfficerId($authorizingOfficerId);
            $sportHasResource ->setSportName($sportName);
            $sportHasResource ->setResourceName($resourceName);
            $sportHasResource ->setAuthorizingOfficerName($authorizingOfficerName);

     

            array_push($sportHasResources,$sportHasResource); //Push one by one
        }
        $stmt->close();
        
        return $sportHasResources;

    }

    public static function delete($id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }


        $stmt = $con->prepare('DELETE  FROM time_slot_resource WHERE sport_has_resource_id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $stmt->close();

        $stmt = $con->prepare('DELETE FROM sport_has_resource WHERE id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();
        $stmt->close();
         
    }

    public function getTimeSlots()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $stmt = $con->prepare('SELECT id,sport_has_resource_id,start_time,end_time,day FROM time_slot_resource where sport_has_resource_id=?');
        $stmt->bind_param("i",$this->id);
        $slots = array();

        if ($stmt->execute()) {
            $stmt->bind_result($id,$sportHasResource,$startTime,$endTime,$day);

            while ( $stmt->fetch() ) {
                $slot = new TimeSlotResource();
                $slot->id = $id;
                $slot->sportHasResourceId = $sportHasResource;
                $slot->startTime = $startTime;
                $slot->endTime = $endTime;
                $slot->day = $day;

                $slots[] = $slot;
            }
            $stmt->close();
            return $slots;

        }
        $stmt->close();
        return false;


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
     * Set sport
     *
     * @param \AppBundle\Entity\Sport $sport
     *
     * @return SportHasResource
     */
    public function setSport(\AppBundle\Entity\Sport $sport = null)
    {
        $this->sport = $sport;

        return $this;
    }

    /**
     * Get sport
     *
     * @return \AppBundle\Entity\Sport
     */
    public function getSport()
    {
        return $this->sport;
    }

    /**
     * Set resource
     *
     * @param \AppBundle\Entity\Resource $resource
     *
     * @return SportHasResource
     */
    public function setResource(\AppBundle\Entity\Resource $resource = null)
    {
        $this->resource = $resource;

        return $this;
    }

    /**
     * Get resource
     *
     * @return \AppBundle\Entity\Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Set authorizingOfficer
     *
     * @param \AppBundle\Entity\AuthorizingOfficer $authorizingOfficer
     *
     * @return SportHasResource
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


//authorizing officer id
    public function setAuthorizingOfficerId($authorizingOfficerId)
    {
        $this->authorizingOfficerId = $authorizingOfficerId;

        return $this;
    }

    public function getAuthorizingOfficerId()
    {
        return $this->authorizingOfficerId;
    }  

//Sport Name
    public function setSportName($sportName)
    {
        $this->sportName = $sportName;

        return $this;
    }

    public function getSportName()
    {
        return $this->sportName;
    } 

//Resource Name
    public function setResourceName($resourceName)
    {
        $this->resourceName = $resourceName;

        return $this;
    }

    public function getResourceName()
    {
        return $this->resourceName;
    } 

//Auth. Officer Name
    public function setAuthorizingOfficerName($authorizingOfficerName)
    {
        $this->authorizingOfficerName = $authorizingOfficerName;

        return $this;
    }

    public function getAuthorizingOfficerName()
    {
        return $this->authorizingOfficerName;
    } 

//resource id
    public function setResourceId($resourceId)
    {
        $this->resourceId = $resourceId;

        return $this;
    }

     public function getResourceId()
    {
        return $this->resourceId;
    } 

//sportId

    public function setSportId($sportId)
    {
        $this->sportId = $sportId;

        return $this;
    }

    public function getSportId()
    {
        return $this->sportId;
    } 

}
