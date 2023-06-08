<?php

namespace App\Controller;

use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategorieController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/categorie', name: 'app_categorie')]
    public function index(): Response
    {
        $entityManager = $this->doctrine->getManager();
        $categories = $entityManager->getRepository(Categorie::class)->findAll();
    
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories
        ]);
    }
    
    

    #[Route('/categorie/{id}', name: 'show_categorie')]
    public function show(Categorie $categorie, int $id): Response
    {
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);

        if (!$categorie) {
            throw $this->createNotFoundException(
                "Pas de catégorie troubée pour l'id ".$id
            );
        }
}
}