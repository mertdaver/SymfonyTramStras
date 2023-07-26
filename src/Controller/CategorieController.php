<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use App\Entity\Categorie;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;


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
    public function show(int $id, Request $request, TokenStorageInterface $tokenStorage): Response
    {
        $entityManager = $this->doctrine->getManager();
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);
    
        // vérifie si catégorie existe
        if (!$categorie) {
            return $this->redirectToRoute('app_categorie');
        }
    
        $topics = $categorie->getTopics();
    
        $topic = new Topic();
        $topic->setCategorie($categorie); // Associe le topic à la catégorie
        $form = $this->createForm(TopicType::class, $topic);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $topic->setCategorie($categorie);
    
            // Vérifier si l'utilisateur est connecté
            if (!$this->isGranted('IS_AUTHENTICATED_FULLY')) {
                throw new AccessDeniedException('Accès refusé. Vous devez être connecté.');
            }
    
            // Récupérer l'utilisateur connecté
            $user = $tokenStorage->getToken()->getUser();
            $topic->setUser($user);
    
            // Récupérer la date de création
            $creationDate = new \DateTime();
            $topic->setCreationDate($creationDate);
    
            $entityManager->persist($topic);
            $entityManager->flush();
        }
    
        // Récupérer l'utilisateur connecté s'il existe
        $user = $this->getUser();
    
        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'topics' => $topics,
            'form' => $form->createView(),
            'is_authenticated' => $this->isGranted('IS_AUTHENTICATED_FULLY'),
            'user' => $user,
        ]);
    }
    
}