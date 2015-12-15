<?php 
namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="authorizing_officer")
 */
class Authorizing_Officer
{
    
     /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=128)
     */
    protected $name;

     /**
     * @ORM\Column(type="string", length=45)
     */
    protected $contact_Nu;


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
     * @return Authorizing_Officer
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
     * @return Authorizing_Officer
     */
    public function setContactNu($contactNu)
    {
        $this->contact_Nu = $contactNu;

        return $this;
    }

    /**
     * Get contactNu
     *
     * @return string
     */
    public function getContactNu()
    {
        return $this->contact_Nu;
    }
}
