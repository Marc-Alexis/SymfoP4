<?php

namespace Louvre\BilletBundle\Stripe;

use Louvre\BilletBundle\Entity\Reservation;

class Stripe
{

    public function createCharge(Reservation $reserv, $prix, $token)
    {
        // Set your secret key: remember to change this to your live secret key in production
        // See your keys here: https://dashboard.stripe.com/account/apikeys
        \Stripe\Stripe::setApiKey('sk_test_I7etF6KkUmb6ml5LcXjPwS1d');

        // Create a charge: this will charge the user's card
        try {
            \Stripe\Charge::create(array(
                "amount" => $prix*100, // Amount in cents
                "currency" => "eur",
                "source" => $token,
                "description" => "Musée du louvre_".$reserv->getCode(),
            ));
            $status = true;
        } catch(\Stripe\Error\Card $e) {
            // The card has been declined
            $status = false;
        }

        return $status;
    }

}
