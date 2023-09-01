<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Entity\Alerte;
use App\Form\TopicType;
use App\Entity\Categorie;
use App\Repository\AlerteRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class TopicController extends AbstractController
{
    #[Route('/topic', name: 'app_topic')]
    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
        $topics = $this->getDoctrine()->getRepository(Topic::class)->findAll();

        return $this->render('topic/index.html.twig', [
            'categories' => $categories,
            'topics' => $topics,
        ]);
    }

    #[Route('/topic/create', name: 'add_topic')]
    public function add(Request $request): Response
    {
        $topic = new Topic();
        $form = $this->createForm(TopicType::class, $topic);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($topic);
            $entityManager->flush();

            // Redirection vers la page d'affichage du topic nouvellement créé
            return $this->redirectToRoute('app_topic_show', ['id' => $topic->getId()]);
        }

        return $this->render('topic/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function show(Topic $topic, ManagerRegistry $doctrine, AlerteRepository $alerteRepo): Response
    {
        $latestAlert = $alerteRepo->findOneBy([], ['id' => 'DESC']);
        $posts = $doctrine->getRepository(Post::class)->findBy(['topic' => $topic]);
    
        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
            'posts' => $posts,
            'latestAlert' => $latestAlert
        ]);
    }
    

    #[Route('/topic/{id}/delete', name: 'delete_topic')]
    public function delete(ManagerRegistry $doctrine, Topic $topic): Response
    {

        $currentUser = $this->getUser();

            // Vérifier si l'utilisateur est connecté
        if (!$currentUser) {
            throw new AccessDeniedException('Vous devez être connecté pour supprimer un topic.');
        }

        // Vérifier si l'utilisateur actuel est l'auteur du topic ou a un rôle d'administrateur
        if ($currentUser !== $topic->getAuthor() && !$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas les autorisations nécessaires pour supprimer ce topic.');
        }

        $entityManager = $doctrine->getManager();
    
        // Récupérer tous les posts associés au topic
        $posts = $topic->getPosts();
    
        // Supprimer les posts un par un
        foreach ($posts as $post) {
            $entityManager->remove($post);
        }
    
        // Supprimer le topic
        $entityManager->remove($topic);
        $entityManager->flush();
    
        return $this->redirectToRoute('app_categorie');
    }
    
}
