<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PhoneNumberAuthOfficer
 *
 * @ORM\Table(name="phone_number_auth_officer", indexes={@ORM\Index(name="fk_phone_number_auth_officer_authorizing_officer1_idx", columns={"authorizing_officer_id"})})
 * @ORM\Entity
 */
class PhoneNumberAuthOfficer
{
    /**
     * @var integer
     *
     * @ORM\Column(name="number", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $number;

    /**
     * @var \AppBundle\Entity\AuthorizingOfficer
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\AuthorizingOfficer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="authorizing_officer_id", referencedColumnName="id")
     * })
     */
    private $authorizingOfficer;



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
     * Set authorizingOfficer
     *
     * @param \AppBundle\Entity\AuthorizingOfficer $authorizingOfficer
     *
     * @return PhoneNumberAuthOfficer
     */
    public function setAuthorizingOfficer(\AppBundle\Entity\AuthorizingOfficer $authorizingOfficer = null)
    {
        $this->authorizingOfficer = $authorizingOfficer;

        return $this;
    }

    /**
     * Get authorizingOfficer
     *
     * @return \AppBundle\Entity\AuthorizingOfficer
     */
    public function getAuthorizingOfficer()
    {
        return $this->authorizingOfficer;
    }
}
