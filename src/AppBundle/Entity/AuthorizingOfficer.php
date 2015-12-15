<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * AuthorizingOfficer
 *
 * @ORM\Table(name="authorizing_officer")
 * @ORM\Entity
 */
class AuthorizingOfficer
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_nu", type="string", length=45, nullable=true)
     */
    private $contactNu;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    public function save()
    {
        $stmt = $this->getEntityManager()  
                   ->getConnection()  
                   ->prepare('INSERT INTO authorizing_officer ('name','contact_nu') VALUES (?,?) ');  
        $stmt->bindValue(1, $name);  
        $stmt->bindValue(2, $contactNu);  
        $stmt->execute();  
        return $stmt->fetchAll();  
    }



    /**
     * Set name
     *
     * @param string $name
     *
     * @return AuthorizingOfficer
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
     * @return AuthorizingOfficer
     */
    public function setContactNu($contactNu)
    {
        $this->contactNu = $contactNu;

        return $this;
    }

    /**
     * Get contactNu
     *
     * @return string
     */
    public function getContactNu()
    {
        return $this->contactNu;
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
}
