<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlertePerturbationController extends AbstractController
{
    #[Route('/alerte/perturbation', name: 'app_alerte_perturbation')]
    public function index(): Response
    {
        return $this->render('alerte_perturbation/index.html.twig', [
            'AlertePerturbation1' => 'AlertePerturbation',
        ]);
    }
}
