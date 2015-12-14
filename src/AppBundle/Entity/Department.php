<?php 
namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="department")
 */
class Department
{
	
	 /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=45)
     */
    protected $name;

     /**
     * @ORM\Column(type="integer")
     */
    protected $faculty_id;


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
     * @return Department
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
     * Set facultyId
     *
     * @param integer $facultyId
     *
     * @return Department
     */
    public function setFacultyId($facultyId)
    {
        $this->faculty_id = $facultyId;

        return $this;
    }

    /**
     * Get facultyId
     *
     * @return integer
     */
    public function getFacultyId()
    {
        return $this->faculty_id;
    }
}
