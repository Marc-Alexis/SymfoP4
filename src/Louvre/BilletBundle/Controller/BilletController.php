<?php

namespace Louvre\BilletBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BilletController extends Controller
{
    public function indexAction()
    {
        return $this->render('LouvreBilletBundle:Billet:index.html.twig');
    }
}
