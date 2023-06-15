<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\TopicType;
use App\Form\PostType;
use App\Entity\Categorie;
use Doctrine\ORM\EntityManagerInterface;
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

    #[Route('/topic/{id}', name: 'app_topic_show')]
    public function show(Request $request, Topic $topic, EntityManagerInterface $entityManager): Response
    {
        $posts = $topic->getPosts(); // Supposons que vous avez une relation entre Topic et Post (One-to-Many)
    
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setTopic($topic);
            $post->setUser($this->getUser());
            $post->setDatePost(new \DateTime());
    
            $entityManager->persist($post);
            $entityManager->flush();
    
            // Redirection vers la page d'affichage du topic
            return $this->redirectToRoute('app_topic_show', ['id' => $topic->getId()]);
        }
    
        return $this->render('topic/show.html.twig', [
            'topic' => $topic,
            'posts' => $posts,
            'form' => $form->createView(),
        ]);
    }
    
    

    #[Route('/topic/{id}/delete', name: 'delete_topic')]
    public function delete(ManagerRegistry $doctrine, Topic $topic): Response
    {
        $entityManager = $doctrine->getManager();
        $entityManager->remove($topic);
        $entityManager->flush();

        return $this->redirectToRoute('app_categorie');

    }
}
