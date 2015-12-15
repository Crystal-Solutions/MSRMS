<?php 
namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="faculty")
 */
class Faculty
{
    
     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Department", mappedBy="faculty")
     */
    protected $Departments;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->Departments = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Faculty
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
     * Add department
     *
     * @param \AppBundle\Entity\Department $department
     *
     * @return Faculty
     */
    public function addDepartment(\AppBundle\Entity\Department $department)
    {
        $this->Departments[] = $department;

        return $this;
    }

    /**
     * Remove department
     *
     * @param \AppBundle\Entity\Department $department
     */
    public function removeDepartment(\AppBundle\Entity\Department $department)
    {
        $this->Departments->removeElement($department);
    }

    /**
     * Get departments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDepartments()
    {
        return $this->Departments;
    }
}
