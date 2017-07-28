<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * @Route("/{name}")
     */
    public function showAction($name)
    {
        $notes = [
            'Coder !',
            'Manger des pâtes',
            'Dormir',
            'Recommencer'
        ];
        return $this->render('pages/home.html.twig', [
            'name' => $name,
            'notes' => $notes
        ]);
    }
}