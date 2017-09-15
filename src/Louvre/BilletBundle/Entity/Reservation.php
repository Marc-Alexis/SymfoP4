<?php

namespace Louvre\BilletBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Reservation
 *
 * @ORM\Table(name="reservation")
 * @ORM\Entity(repositoryClass="Louvre\BilletBundle\Repository\ReservationRepository")
 */
class Reservation
{
    /**
     * @ORM\OneToMany(targetEntity="Louvre\BilletBundle\Entity\Billet", mappedBy="reservation", cascade={"persist"})
     */
    private $billets;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="code", type="string", length=255)
     */
    private $code;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datereserv", type="datetime")
     * @Assert\DateTime()
     */
    private $datereserv;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datevisite", type="date")
     * @Assert\Date()
     */
    private $datevisite;

    /**
     * @var float
     *
     * @ORM\Column(name="prixtot", type="float")
     */
    private $prixtot;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var integer
     *
     * @ORM\Column(name="nb_billets", type="integer")
     */
    private $nbBillets;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set code
     *
     * @param string $code
     *
     * @return Reservation
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set datereserv
     *
     * @param \DateTime $datereserv
     *
     * @return Reservation
     */
    public function setDatereserv($datereserv)
    {
        $this->datereserv = $datereserv;

        return $this;
    }

    /**
     * Get datereserv
     *
     * @return \DateTime
     */
    public function getDatereserv()
    {
        return $this->datereserv;
    }

    /**
     * Set prixtot
     *
     * @param float $prixtot
     *
     * @return Reservation
     */
    public function setPrixtot($prixtot)
    {
        $this->prixtot = $prixtot;

        return $this;
    }

    /**
     * Get prixtot
     *
     * @return float
     */
    public function getPrixtot()
    {
        return $this->prixtot;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->billets = new \Doctrine\Common\Collections\ArrayCollection();
        $this->setCode(uniqid());
        $this->setDatereserv(new \DateTime('now'));
    }

    /**
     * Add billet
     *
     * @param \Louvre\BilletBundle\Entity\Billet $billet
     *
     * @return Reservation
     */
    public function addBillet(\Louvre\BilletBundle\Entity\Billet $billet)
    {
        $this->billets[] = $billet;
        $billet->setReservation($this);

        return $this;
    }

    /**
     * Remove billet
     *
     * @param \Louvre\BilletBundle\Entity\Billet $billet
     */
    public function removeBillet(\Louvre\BilletBundle\Entity\Billet $billet)
    {
        $this->billets->removeElement($billet);
    }

    /**
     * Get billets
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getBillets()
    {
        return $this->billets;
    }

    /**
     * Set datevisite
     *
     * @param \DateTime $datevisite
     *
     * @return Reservation
     */
    public function setDatevisite($datevisite)
    {
        $this->datevisite = $datevisite;

        return $this;
    }

    /**
     * Get datevisite
     *
     * @return \DateTime
     */
    public function getDatevisite()
    {
        return $this->datevisite;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Reservation
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set nbBillets
     *
     * @param integer $nbBillets
     *
     * @return Reservation
     */
    public function setNbBillets($nbBillets)
    {
        $this->nbBillets = $nbBillets;

        return $this;
    }

    /**
     * Get nbBillets
     *
     * @return integer
     */
    public function getNbBillets()
    {
        return $this->nbBillets;
    }
}
