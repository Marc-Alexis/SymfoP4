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

    public function underMilleBillets(\DateTime $date, $nbBilletsReserv)
    {
        $reservsToCheck = $this->em->getRepository('LouvreBilletBundle:Reservation')->getReservationsByDate($date);
        $total = $nbBilletsReserv;

        foreach ($reservsToCheck as $reserv)
        {
            $nbBillets = $reserv->getNbBillets();
            $total += $nbBillets;
        }

        if ($total <= 5)
        {
            $answer = true;
        } else {
            $answer = false;
        }

        return $answer;
    }

}