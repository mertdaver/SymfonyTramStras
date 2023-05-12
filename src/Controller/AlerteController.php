<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlerteController extends AbstractController
{
    #[Route('/alerte', name: 'app_alerte')]
    public function index(): Response
    {
        $tableauAlertes = ["valeur 1", "valeur 2"];
        return $this->render('alerte/index.html.twig', [
            'Alerte1' => 'Alice à émit une Alerte dans le tram D direction Kelh',
            'tableauAlertes' =>  $tableauAlertes ,
        ]);
    }
}
