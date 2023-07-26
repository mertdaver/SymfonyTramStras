<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Topic;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PostController extends AbstractController
{
    #[Route('/post', name: 'app_post')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $posts = $doctrine->getRepository(Post::class)->findAll();

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/topic/{id}', name: 'app_topic_show')]
    public function show(Request $request, Topic $topic = null, ManagerRegistry $doctrine): Response
    {
        if (!$topic) {
            return $this->redirectToRoute('app_categorie');
        }
    
        $posts = $doctrine->getRepository(Post::class)->findBy(['topic' => $topic]);
    
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setTopic($topic);
            $post->setUser($this->getUser());
            $post->setDatePost(new \DateTime());
    
            $entityManager = $doctrine->getManager();
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
    
    


    #[Route('/post/create/{id}', name: 'add_post')]
    public function add(Request $request, $id): Response
    {
        $topic = $this->getDoctrine()->getRepository(Topic::class)->find($id);
    
        if (!$topic) {
            throw $this->createNotFoundException('Le topic n\'existe pas.');
        }
    
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setTopic($topic);
            $post->setUser($this->getUser());
            $post->setDatePost(new \DateTime());
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
    
            // Redirection vers la page d'affichage du topic
            return $this->redirectToRoute('app_topic_show', ['id' => $topic->getId()]);
        }
    
        return $this->render('post/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/post/{id}/delete', name: 'delete_post')]
    public function deletePost(EntityManagerInterface $entityManager, Post $post): Response
    {
        // Vérifier si l'utilisateur actuel est l'auteur du post
        if ($post->getUser() !== $this->getUser()) {
            throw new AccessDeniedException('Vous n\'êtes pas autorisé à supprimer ce post.');
        }
    
        $entityManager->remove($post);
        $entityManager->flush();
    
        // Redirection vers la page d'affichage du topic
        return $this->redirectToRoute('app_topic_show', ['id' => $post->getTopic()->getId()]);
    }
}
