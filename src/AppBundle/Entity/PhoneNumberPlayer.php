<?php 
namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="phone_number_player")
 */
class PhoneNumberPlayer
{
	
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    protected $number;


    /**
     * @ORM\ManyToOne(targetEntity="Player", inversedBy="phoneNumbers")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id")
     */
    protected $player;


    /**
     * Set number
     *
     * @param integer $number
     *
     * @return PhoneNumberPlayer
     */
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
     * Set player
     *
     * @param \AppBundle\Entity\Player $player
     *
     * @return PhoneNumberPlayer
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
}
