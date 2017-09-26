<?php

namespace Louvre\BilletBundle\Limitator;

use Doctrine\ORM\EntityManagerInterface;

class Limitator
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function underMilleBillets(\DateTime $date = null, $nbBilletsReserv)
    {
        $reservsToCheck = $this->em->getRepository('LouvreBilletBundle:Reservation')->getReservationsByDate($date);
        $total = $nbBilletsReserv;

        if (isset($date) && !empty($date)):
            foreach ($reservsToCheck as $reserv)
            {
                $nbBillets = $reserv->getNbBillets();
                $total += $nbBillets;
            }
        endif;

        return $total;
    }

    public function JourneeClosed(\DateTime $date = null, $billets)
    {
        $now = new \DateTime('now');
        $today = $now->format('d-m-y');
        $heure = $now->format('h')+2;
        $datevisite = $date->format('d-m-y');

        foreach ($billets as $billet) {
            $type = $billet->getType();
            if ($datevisite == $today && $heure >= 14 && $type == "Journée") {
                $closed = true;
                break;
            } else {
                $closed = false;
            }
        }
        return $closed;
    }
}