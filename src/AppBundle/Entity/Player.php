<?php
namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="player")
 */
class Player
{
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	protected $id;

	/**
     * @ORM\Column(type="string", length=140)
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Department", inversedBy="players")
     * @ORM\JoinColumn(name="department_id", referencedColumnName="id")
     */
    protected $department;

    /**
     * @ORM\ManyToOne(targetEntity="Faculty", inversedBy="players")
     * @ORM\JoinColumn(name="faculty_id", referencedColumnName="id")
     */
    protected $faculty;

   	/**
     * @ORM\Column(type="integer")
     */
    protected $year;

       	/**
     * @ORM\Column(type="date")
     */
    protected $dateOfBirth;

    /**
     * @ORM\Column(type="string", length=450)
     */
    protected $address;

     /**
     * @ORM\Column(type="string", length=2)
     */
    protected $bloodType;

    /**
     * @ORM\OneToMany(targetEntity="PhoneNumberPlayer", mappedBy="player")
     */
    protected $PhoneNumbers;

    
}

?>