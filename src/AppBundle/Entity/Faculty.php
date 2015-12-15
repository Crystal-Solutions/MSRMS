<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;


/**
 * Faculty
 *
 * @ORM\Table(name="faculty")
 * @ORM\Entity
 */
class Faculty
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=45, nullable=true)
     */
    private $name;

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
               ->prepare('INSERT INTO Faculty (name) VALUES (?)');  
        $stmt->bindValue('1', $name);  
        $stmt->execute();  
        return $stmt->fetchAll();  

        //>prepare('INSERT INTO Faculty (name) VALUES (?)');
        //>prepare('SELECT COUNT(id) AS num, foo FROM bar WHERE foobar = :foobar GROUP BY foo');

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
