<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Controller\Connection;
/**
 * PlayerInvolvedInSport
 *
 * @ORM\Table(name="player_involved_in_sport", indexes={@ORM\Index(name="fk_player_has_sport_sport1_idx", columns={"sport_id"}), @ORM\Index(name="fk_player_has_sport_player1_idx", columns={"player_id"})})
 * @ORM\Entity
 */
class PlayerInvolvedInSport
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="started_date", type="date", nullable=false)
     */
    private $startedDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="date", nullable=true)
     */
    private $endDate;

    /**
     * @var string
     *
     * @ORM\Column(name="position", type="string", length=45, nullable=true)
     */
    private $position;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    public $id;

    /**
     * @var \AppBundle\Entity\Sport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Sport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="sport_id", referencedColumnName="id")
     * })
     */
    private $sport;

    /**
     * @var \AppBundle\Entity\Player
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * })
     */
    private $player;

    private $playerId;
    private $sportId;

    private $playerName;
    private $sportName;


    public function save()
    {

        $this->startedDate = $this->startedDate->format('Y-m-d');
        $this->endDate = $this->endDate?$this->endDate->format('Y-m-d'):null;
    

        if($this->id==null)
        {
           
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('INSERT INTO `player_involved_in_sport` (`player_id`,`sport_id`,`started_date`, `end_date`, `position`) VALUES (?,?,?,?,?)');  
        $stmt->bind_param("iisss",$this->playerId,$this->sportId,$this->startedDate,$this->endDate,$this->position);  
        $stmt->execute();  
        $stmt->close();
        }
        else
        {
        $con = Connection::getConnectionObject()->getConnection();
        $stmt = $con->prepare('UPDATE player_involved_in_sport SET player_id =?,sport_id=?,started_date=?,end_date=?,position=? WHERE id=?');  
        $stmt->bind_param("iisssi",$this->player_id,$this->sport_id,$this->startedDate,$this->endDate,$this->position,$this->id);  
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

        $playerInvolvedInSport = new PlayerInvolvedInSport();
        $stmt = $con->prepare('SELECT player_involved_in_sport.id,player_involved_in_sport.player_id,player_involved_in_sport.sport_id,player_involved_in_sport.started_date,player_involved_in_sport.end_date,player_involved_in_sport.position,player.name,sport.name FROM player_involved_in_sport,sport,player WHERE player_involved_in_sport.player_id = player.id and player_involved_in_sport.sport_id = sport.id and id=?');
        $stmt->bind_param("s",$id);
        $stmt->execute();

        $stmt->bind_result($playerInvolvedInSport->id,$playerInvolvedInSport->player_id,$playerInvolvedInSport->sport_id,$playerInvolvedInSport->startedDate,$playerInvolvedInSport->endDate,$playerInvolvedInSport->position,$playerInvolvedInSport->playerName,$playerInvolvedInSport->sportName);
        $stmt->fetch();
        $stmt->close();
        return $playerInvolvedInSport;
    }


    public static function getAll()
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $playerInvolvedInSports = array(); //Make an empty array - don't mind the name
        $stmt = $con->prepare('SELECT player_involved_in_sport.id,player_involved_in_sport.player_id,player_involved_in_sport.sport_id,player_involved_in_sport.started_date,player_involved_in_sport.end_date,player_involved_in_sport.position,player.name,sport.name FROM player_involved_in_sport,sport,player WHERE player_involved_in_sport.player_id = player.id and player_involved_in_sport.sport_id = sport.id');
        $stmt->execute();
        $stmt->bind_result($id,$playerId,$sportId,$startedDate,$endDate,$position,$playerName,$sportName);
        while($stmt->fetch())
        {
            $playerInvolvedInSport = new PlayerInvolvedInSport();
            $playerInvolvedInSport->id=$id;
            //check here k
            $playerInvolvedInSport->setPlayerId($playerId);
            $playerInvolvedInSport->setSportId($sportId);
            $playerInvolvedInSport->setStartedDate($startedDate);
            $playerInvolvedInSport->setEndDate($endDate);
            $playerInvolvedInSport->setPosition($position);
            $playerInvolvedInSport->setPlayerName($playerName);
            $playerInvolvedInSport->setSportName($sportName);
     

            array_push($playerInvolvedInSports,$playerInvolvedInSport); //Push one by one
        }
        $stmt->close();
        
        return $playerInvolvedInSports;

    }

    //get all involvements of a player-Shanika
    public static function getplayerAll($p_id)
    {
        $con = Connection::getConnectionObject()->getConnection();
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        }

        $playerInvolvedInSports = array(); //Make an empty array - don't mind the name
        $stmt = $con->prepare('SELECT id,player_id,sport_id,started_date,end_date,position FROM player_involved_in_sport WHERE player_id=?');
        $stmt->bind_param("s",$p_id);
        $stmt->execute();

        $stmt->bind_result($id,$playerId,$sportId,$startedDate,$endDate,$position);
        while($stmt->fetch())
        {
            $playerInvolvedInSport = new PlayerInvolvedInSport();
            $playerInvolvedInSport->id=$id;
            //check here k
            $playerInvolvedInSport->setPlayerId($playerId);
            $playerInvolvedInSport->setSportId($sportId);
            $playerInvolvedInSport->setStartedDate($startedDate);
            $playerInvolvedInSport->setEndDate($endDate);
            $playerInvolvedInSport->setPosition($position);

            $playerInvolvedInSport->setPlayerName($playerName);
            $playerInvolvedInSport->setSportName($sportName);

            array_push($playerInvolvedInSports,$playerInvolvedInSport); //Push one by one
        }
        $stmt->close();
        
        return $playerInvolvedInSports;

    }

    /**
     * Set startedDate
     *
     * @param \DateTime $startedDate
     *
     * @return PlayerInvolvedInSport
     */
    public function setStartedDate($startedDate)
    {
        $this->startedDate = $startedDate;

        return $this;
    }

    /**
     * Get startedDate
     *
     * @return \DateTime
     */
    public function getStartedDate()
    {
        return $this->startedDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return PlayerInvolvedInSport
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set position
     *
     * @param string $position
     *
     * @return PlayerInvolvedInSport
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return string
     */
    public function getPosition()
    {
        return $this->position;
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
     * @return PlayerInvolvedInSport
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
     * Set player
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return PlayerInvolvedInSport
     */
    public function setPlayer(\AppBundle\Entity\Player $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return \AppBundle\Entity\Player
     */
    public function getPlayer()
    {
        return $this->player;
    }

//manually added

    public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;

        return $this;
    }

  /* add if u want  -r/**
     * Get playerId
     *
     * @return integer
     */
    public function getPlayerId()
    {
        return $this->playerId;
    }   

        public function setSportId($sportId)
    {
        $this->sportId = $sportId;

        return $this;
    }

    public function getSportId()
    {
        return $this->sportId;
    } 

    //playerName
    public function setPlayerName($playerName)
    {
        $this->playerName = $playerName;

        return $this;
    }

     public function getPlayerName()
    {
        return $this->playerName;
    } 

    //sportName
    public function setSportName($sportName)
    {
        $this->sportName = $sportName;

        return $this;
    }

     public function getSportName()
    {
        return $this->sportName;
    }  
}
