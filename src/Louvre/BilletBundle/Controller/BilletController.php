<?php

namespace Louvre\BilletBundle\Controller;

use Louvre\BilletBundle\Entity\Reservation;
use Louvre\BilletBundle\Form\ReservationType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class BilletController extends Controller
{
    public function indexAction(Request $request)
    {
        $reserv = new Reservation();
        $form = $this->get('form.factory')->create(ReservationType::class, $reserv);
        $prixator = $this->get('louvre_billet.prixator');
        $limitator = $this->get('louvre.billet_limitator');

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
        {
            $datevisite = $reserv->getDatevisite();
            $nbBilletsReserv = $reserv->getNbBillets();
            $under = $limitator->underMilleBillets($datevisite, $nbBilletsReserv);

            if ($under == false)
            {
                $request->getSession()->getFlashBag()->add('error', 'Désolé, il ne nous reste plus assez de billets à cette date pour effectuer votre réservation. Veuillez choisir une autre date');
                return $this->redirectToRoute('louvre_billet_homepage');
            } else {
                $prixator->PrixBirthdate($reserv);

                $session = new Session();
                $session->set('reservation', $reserv);

                $request->getSession()->getFlashBag()->add('notice', 'La réservation a bien été enregistrée.');

                return $this->redirectToRoute('louvre_billet_payment');
            }
        }

        return $this->render('LouvreBilletBundle:Billet:index.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function paymentAction(Request $request)
    {
        $session = new Session();
        $reserv = $session->get('reservation');
        $price = $reserv->getPrixtot();
        $email = $reserv->getEmail();
        $em = $this->getDoctrine()->getManager();

        if ($request->isMethod('POST'))
        {
            $token = $request->request->get('stripeToken');
            $stripe = $this->get('louvre_billet.stripe')->createCharge($reserv, $price, $token);

            if ($stripe == true)
            {
                $em->persist($reserv);
                $em->flush();
                $this->get('louvre_billet.mailer')->sendMail($reserv, $price);
            }
            return $this->redirectToRoute('louvre_billet_confirmation');
        }

        return $this->render('LouvreBilletBundle:Billet:payment.html.twig', array(
            'price' => $price,
            'email' => $email,
        ));
    }

    public function confirmationAction()
    {
        $session = new Session();
        $reserv = $session->get('reservation');
        $mail = $reserv->getEmail();
        $code = $reserv->getCode();
        $session->remove('reservation');

        return $this->render('LouvreBilletBundle:Billet:confirmation.html.twig', array(
            'mail' => $mail,
            'code' => $code,
        ));
    }
}
