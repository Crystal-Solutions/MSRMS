<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EquipmentBorrowedByPlayer
 *
 * @ORM\Table(name="equipment_borrowed_by_player", indexes={@ORM\Index(name="fk_equipment_has_player_player2_idx", columns={"player_id"}), @ORM\Index(name="fk_equipment_has_player_equipment2_idx", columns={"equipment_id"})})
 * @ORM\Entity
 */
class EquipmentBorrowedByPlayer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer", nullable=true)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="borrowed_time", type="datetime", nullable=true)
     */
    private $borrowedTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="due_time", type="datetime", nullable=true)
     */
    private $dueTime;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="returned_time", type="datetime", nullable=true)
     */
    private $returnedTime;

    /**
     * @var string
     *
     * @ORM\Column(name="issue_details", type="string", length=850, nullable=true)
     */
    private $issueDetails;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\Player
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Player")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     * })
     */
    private $player;

    /**
     * @var \AppBundle\Entity\Equipment
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Equipment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="equipment_id", referencedColumnName="id")
     * })
     */
    private $equipment;



    /**
     * Set amount
     *
     * @param integer $amount
     *
     * @return EquipmentBorrowedByPlayer
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
     * Set borrowedTime
     *
     * @param \DateTime $borrowedTime
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setBorrowedTime($borrowedTime)
    {
        $this->borrowedTime = $borrowedTime;

        return $this;
    }

    /**
     * Get borrowedTime
     *
     * @return \DateTime
     */
    public function getBorrowedTime()
    {
        return $this->borrowedTime;
    }

    /**
     * Set dueTime
     *
     * @param \DateTime $dueTime
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setDueTime($dueTime)
    {
        $this->dueTime = $dueTime;

        return $this;
    }

    /**
     * Get dueTime
     *
     * @return \DateTime
     */
    public function getDueTime()
    {
        return $this->dueTime;
    }

    /**
     * Set returnedTime
     *
     * @param \DateTime $returnedTime
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setReturnedTime($returnedTime)
    {
        $this->returnedTime = $returnedTime;

        return $this;
    }

    /**
     * Get returnedTime
     *
     * @return \DateTime
     */
    public function getReturnedTime()
    {
        return $this->returnedTime;
    }

    /**
     * Set issueDetails
     *
     * @param string $issueDetails
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setIssueDetails($issueDetails)
    {
        $this->issueDetails = $issueDetails;

        return $this;
    }

    /**
     * Get issueDetails
     *
     * @return string
     */
    public function getIssueDetails()
    {
        return $this->issueDetails;
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
     * Set player
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return EquipmentBorrowedByPlayer
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

    /**
     * Set equipment
     *
     * @param \AppBundle\Entity\Equipment $equipment
     *
     * @return EquipmentBorrowedByPlayer
     */
    public function setEquipment(\AppBundle\Entity\Equipment $equipment = null)
    {
        $this->equipment = $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return \AppBundle\Entity\Equipment
     */
    public function getEquipment()
    {
        return $this->equipment;
    }
}
