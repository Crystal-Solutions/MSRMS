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

    


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->PhoneNumbers = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     *
     * @return Player
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
     * Set year
     *
     * @param integer $year
     *
     * @return Player
     */
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * Get year
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set dateOfBirth
     *
     * @param \DateTime $dateOfBirth
     *
     * @return Player
     */
    public function setDateOfBirth($dateOfBirth)
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    /**
     * Get dateOfBirth
     *
     * @return \DateTime
     */
    public function getDateOfBirth()
    {
        return $this->dateOfBirth;
    }

    /**
     * Set address
     *
     * @param string $address
     *
     * @return Player
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set bloodType
     *
     * @param string $bloodType
     *
     * @return Player
     */
    public function setBloodType($bloodType)
    {
        $this->bloodType = $bloodType;

        return $this;
    }

    /**
     * Get bloodType
     *
     * @return string
     */
    public function getBloodType()
    {
        return $this->bloodType;
    }

    /**
     * Set department
     *
     * @param \AppBundle\Entity\Department $department
     *
     * @return Player
     */
    public function setDepartment(\AppBundle\Entity\Department $department = null)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department
     *
     * @return \AppBundle\Entity\Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set faculty
     *
     * @param \AppBundle\Entity\Faculty $faculty
     *
     * @return Player
     */
    public function setFaculty(\AppBundle\Entity\Faculty $faculty = null)
    {
        $this->faculty = $faculty;

        return $this;
    }

    /**
     * Get faculty
     *
     * @return \AppBundle\Entity\Faculty
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * Add phoneNumber
     *
     * @param \AppBundle\Entity\PhoneNumberPlayer $phoneNumber
     *
     * @return Player
     */
    public function addPhoneNumber(\AppBundle\Entity\PhoneNumberPlayer $phoneNumber)
    {
        $this->PhoneNumbers[] = $phoneNumber;

        return $this;
    }

    /**
     * Remove phoneNumber
     *
     * @param \AppBundle\Entity\PhoneNumberPlayer $phoneNumber
     */
    public function removePhoneNumber(\AppBundle\Entity\PhoneNumberPlayer $phoneNumber)
    {
        $this->PhoneNumbers->removeElement($phoneNumber);
    }

    /**
     * Get phoneNumbers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPhoneNumbers()
    {
        return $this->PhoneNumbers;
    }
}
