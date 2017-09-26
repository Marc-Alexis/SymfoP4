<?php

namespace Tests\Louvre\BilletBundle\Prixator;

use Louvre\BilletBundle\Entity\Billet;
use Louvre\BilletBundle\Entity\Reservation;
use Louvre\BilletBundle\Prixator\Prixator;
use PHPUnit\Framework\TestCase;

class PrixatorTest extends TestCase
{
    public function testPrixBirthdate()
    {
        $reserv = new Reservation();
        $billet = new Billet();
        $billet->setFullname('Jean Martin');
        $billet->setBirthdate(new \DateTime('1999-01-01'));
        $billet->setNationalite('AF');
        $billet->setTarifreduit(0);
        $billet->setType('Journée');

        $billet2 = new Billet();
        $billet2->setFullname('Jean Bon');
        $billet2->setBirthdate(new \DateTime('1980-01-01'));
        $billet2->setNationalite('FR');
        $billet2->setTarifreduit(0);
        $billet2->setType('Demi-Journée');

        $billet3 = new Billet();
        $billet3->setFullname('Jean Martin');
        $billet3->setBirthdate(new \DateTime('1999-01-01'));
        $billet3->setNationalite('AF');
        $billet3->setTarifreduit(1);
        $billet3->setType('Journée');

        $reserv->addBillet($billet);
        $reserv->addBillet($billet2);
        $reserv->addBillet($billet3);

        $prixator = new Prixator();
        $prixator->PrixBirthdate($reserv);

        $expectedPrice = $reserv->getPrixtot();
        $expectedNbBillets = $reserv->getNbBillets();

        $this->assertEquals(34, $expectedPrice);
        $this->assertEquals(3, $expectedNbBillets);
    }
}