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
        $categories = $entityManager->getRepository(Categorie::class)->findBy([], ["nom_categorie" => "ASC"]);
    // findBy pour trier par nom_categorie dans l'ordre
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories
        ]);
    }
    
    
    #[Route('/categorie/{id}', name: 'show_categorie')]
    public function show(int $id): Response
    {
        $entityManager = $this->doctrine->getManager();
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);

        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie
        ]);
    }
    
    
    
}