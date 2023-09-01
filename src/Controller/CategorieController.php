<?php

namespace App\Controller;

use App\Entity\Topic;
use App\Form\TopicType;
use App\Entity\Categorie;
use App\Entity\Alerte;
use Doctrine\ORM\EntityManagerInterface;
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
        
        $latestAlert = $entityManager->getRepository(Alerte::class)->findLatestAlert(); // Récupérer la dernière alerte
        
        return $this->render('categorie/index.html.twig', [
            'categories' => $categories,
            'latestAlert' => $latestAlert, // Passer la dernière alerte à la vue
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

        // Ajout de cette partie pour obtenir la dernière alerte
        $latestAlert = $entityManager->getRepository(Alerte::class)->findLatestAlert();

        return $this->render('categorie/show.html.twig', [
            'categorie' => $categorie,
            'topics' => $topics,
            'form' => $form->createView(),
            'is_authenticated' => $this->isGranted('IS_AUTHENTICATED_FULLY'),
            'user' => $user,
            'latestAlert' => $latestAlert,
        ]);
    }

    #[Route('/categorie/{id}/delete', name: 'delete_categorie')]
    public function delete(int $id, EntityManagerInterface $entityManager): Response
    {
        $categorie = $entityManager->getRepository(Categorie::class)->find($id);

        // Si la catégorie n'existe pas, redirigez vers la liste des catégories.
        if (!$categorie) {
            return $this->redirectToRoute('app_categorie');
        }

        // Vérifiez si l'utilisateur actuel est le créateur de la catégorie.
        if ($categorie->getUser() !== $this->getUser()) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à supprimer cette catégorie.');
        }

        $entityManager->remove($categorie);
        $entityManager->flush();

        return $this->redirectToRoute('app_categorie');
    }

}
