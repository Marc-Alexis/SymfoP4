<?php

namespace Louvre\BilletBundle\Prixator;

use Louvre\BilletBundle\Entity\Reservation;

class Prixator
{
    public function PrixBirthdate(Reservation $reservation)
    {
        $billets = $reservation->getBillets();
        $nbBillets = 0;
        $prixTotal = 0;

        foreach ($billets as $billet):
            $nbBillets++;
            // Récupère l'age du porteur du billet en fct de sa date de naissance
            $now = new \DateTime('now');
            $dob = $billet->getBirthdate();
            $diff = $now->diff($dob);
            $age = $diff->y;

            $tr = $billet->getTarifreduit();

            if ($age >= 12 && $tr == true){
                $billet->setPrix(10);
            } else {
                switch (true):
                    case $age < 4 : $billet->setPrix(0); break;
                    case $age >= 4 && $age < 12 : $billet->setPrix(8); break;
                    case $age >= 12 && $age < 60 : $billet->setPrix(16); break;
                    case $age >= 60 : $billet->setPrix(12); break;
                endswitch;
            }
            $prixTotal += $billet->getPrix();
        endforeach;

        $reservation->setPrixtot($prixTotal);
        $reservation->setNbBillets($nbBillets);
    }
}