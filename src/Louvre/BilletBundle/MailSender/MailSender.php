<?php

namespace Louvre\BilletBundle\MailSender;

use Louvre\BilletBundle\Entity\Reservation;
use Symfony\Component\Templating\EngineInterface;

class MailSender
{
    protected $mailer;
    protected $templating;
    private $from = "marc.alexis.buchert@gmail.com";
    private $reply = "marc.alexis.buchert@gmail.com";
    private $name = "Billetterie du Louvre";

    public function __construct($mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    protected function sendMessage($to, $subject, $reserv, $prix)
    {
        $mail = \Swift_Message::newInstance();
        $image = $mail->embed(\Swift_Image::fromPath('./img/logo.png'));
        $mail
            ->setFrom($this->from,$this->name)
            ->setTo($to)
            ->setSubject($subject)
            ->setBody( $this->templating->render('LouvreBilletBundle:Billet:mail.html.twig', array(
                'reservation' => $reserv,
                'image' => $image,
                'prix' => $prix)))
            ->setReplyTo($this->reply,$this->name)
            ->setContentType('text/html');

        $this->mailer->send($mail);
    }

    public function sendMail(Reservation $reserv, $prix){
        $subject = "Réservation " . $reserv->getCode() . " confirmation";
        $to = $reserv->getEmail();
        $this->sendMessage($to, $subject, $reserv, $prix);
    }
}