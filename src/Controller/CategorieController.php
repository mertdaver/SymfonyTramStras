<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        return $this->render('categorie/index.html.twig', [
            'categorie_generale' => 'Generale',
            'categorie_alerte' => 'Alertes',
            'categorie_LigneA' => 'Ligne A',
            'categorie_LigneB' => 'Ligne B',
            'categorie_LigneC' => 'Ligne C',
            'categorie_LigneD' => 'Ligne D',
            'categorie_LigneE' => 'Ligne E',
            'categorie_LigneF' => 'Ligne F',
        ]);
    }
}
