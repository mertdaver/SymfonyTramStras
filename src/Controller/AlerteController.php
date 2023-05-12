<?php

namespace App\Controller;

use App\Entity\Alerte;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlerteController extends AbstractController
{
    #[Route('/alerte', name: 'app_alerte')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $alertes = $doctrine->getRepository(Alerte::class)->findAll();
{# Ca affiche toutes la liste des alertes mais elles ne doivent s'afficher qu'une fois et en pop-up -> finOne($id) #}
        
        return $this->render('alerte/index.html.twig', [
            
            'Alerte1' => 'Alice à émit une Alerte dans le tram D direction Kelh',
            'alertes' => $alertes,
            
        
        ]);
    }
}
}