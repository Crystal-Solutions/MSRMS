<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Achievement
 *
 * @ORM\Table(name="achievement", indexes={@ORM\Index(name="fk_achievement_player_involved_in_sport1_idx", columns={"player_involved_in_sport_id"})})
 * @ORM\Entity
 */
class Achievement
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=140, nullable=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=850, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="achieved_date", type="date", nullable=true)
     */
    private $achievedDate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \AppBundle\Entity\PlayerInvolvedInSport
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\PlayerInvolvedInSport")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="player_involved_in_sport_id", referencedColumnName="id")
     * })
     */
    private $playerInvolvedInSport;



    /**
     * Set title
     *
     * @param string $title
     *
     * @return Achievement
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Achievement
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
     * Set achievedDate
     *
     * @param \DateTime $achievedDate
     *
     * @return Achievement
     */
    public function setAchievedDate($achievedDate)
    {
        $this->achievedDate = $achievedDate;

        return $this;
    }

    /**
     * Get achievedDate
     *
     * @return \DateTime
     */
    public function getAchievedDate()
    {
        return $this->achievedDate;
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
     * Set playerInvolvedInSport
     *
     * @param \AppBundle\Entity\PlayerInvolvedInSport $playerInvolvedInSport
     *
     * @return Achievement
     */
    public function setPlayerInvolvedInSport(\AppBundle\Entity\PlayerInvolvedInSport $playerInvolvedInSport = null)
    {
        $this->playerInvolvedInSport = $playerInvolvedInSport;

        return $this;
    }

    /**
     * Get playerInvolvedInSport
     *
     * @return \AppBundle\Entity\PlayerInvolvedInSport
     */
    public function getPlayerInvolvedInSport()
    {
        return $this->playerInvolvedInSport;
    }
}
