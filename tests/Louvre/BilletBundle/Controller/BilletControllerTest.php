<?php

namespace Tests\Louvre\BilletBundle\Controller;

use Louvre\BilletBundle\Entity\Reservation;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockFileSessionStorage;

class BilletControllerTest extends WebTestCase
{
    public function testHomePageOK()
    {
        $client = static::createClient();

        $client->request('GET', '/billet/');

        $this->assertSame(200, $client->getResponse()->getStatusCode());
    }

    public function testAccesPaymentAvecReserv()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $session = new Session(new MockFileSessionStorage());
        $container->set('session', $session);
        $reserv = new Reservation();
        $reserv->setPrixtot(16);
        $reserv->setEmail('email@mail.com');
        $reserv->getNbBillets(1);
        $reserv->setDatereserv(new \DateTime('2017-09-14 17:16:51'));
        $reserv->setDatevisite(new \DateTime('2017-01-16'));
        $reserv->setCode('59bbf7fb599d5');
        $session->set('reservation', $reserv);

        $crawler = $client->request('GET', '/billet/payment');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Récapitulatif de votre commande', $crawler->filter('h2')->text());
    }

    public function testAccesPaymentSansReserv()
    {
        $client = static::createClient();
        $client->request('GET', '/billet/payment');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testAccesConfirmationAvecReserv()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $session = new Session(new MockFileSessionStorage());
        $container->set('session', $session);
        $reserv = new Reservation();
        $reserv->setPrixtot(16);
        $reserv->setEmail('email@mail.com');
        $reserv->getNbBillets(1);
        $reserv->setDatereserv(new \DateTime('2017-09-14 17:16:51'));
        $reserv->setDatevisite(new \DateTime('2017-01-16'));
        $reserv->setCode('59bbf7fb599d5');
        $session->set('reservation', $reserv);

        $crawler = $client->request('GET', '/billet/confirmation');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('payée', $crawler->filter('h2')->text());
    }

    public function testAccesConfirmationSansReserv()
    {
        $client = static::createClient();
        $client->request('GET', '/billet/confirmation');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}