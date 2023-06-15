<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\TopicType;
use App\Entity\Categorie;
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

    public function show(Topic $topic, ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(Post::class)->findBy(['topic' => $topic]);
    
        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
            'posts' => $posts,
        ]);
    }
    

    #[Route('/topic/{id}/delete', name: 'delete_topic')]
    public function delete(ManagerRegistry $doctrine, Topic $topic): Response
    {
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
