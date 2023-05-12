<?php

namespace App\Controller;

use App\Entity\AlertePerturbation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlertePerturbationController extends AbstractController
{
    #[Route('/alerte/perturbation', name: 'app_alerte_perturbation')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $alertePerturbations = $doctrine->getRepository(AlertePerturbation::class)->findAll();

        return $this->render('alerte_perturbation/index.html.twig', [
            'alertePerturbations' => $alertePerturbations,
        ]);
    }
}
