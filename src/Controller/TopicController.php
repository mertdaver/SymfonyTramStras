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
        // Récupération de tous les enregistrements de la table 'Categorie' à l'aide de l'ORM Doctrine.
        $categories = $this->getDoctrine()->getRepository(Categorie::class)->findAll();
    
        // Récupération de tous les enregistrements de la table 'Topic' à l'aide de l'ORM Doctrine.
        $topics = $this->getDoctrine()->getRepository(Topic::class)->findAll();
    
        // Rendu de la vue 'topic/index.html.twig' avec les données récupérées (catégories et topics).
        // Les données sont transmises à la vue sous forme d'un tableau associatif.
        return $this->render('topic/index.html.twig', [
            'categories' => $categories,
            'topics' => $topics,
        ]);
    }

    #[Route('/topic/create', name: 'add_topic')]
    public function add(Request $request): Response
    {
        // Instanciation d'un nouvel objet Topic. 
        // Cet objet sera rempli avec les données du formulaire et persisté dans la base de données.
        $topic = new Topic();
    
        // Création du formulaire associé à l'entité Topic.
        $form = $this->createForm(TopicType::class, $topic);
    
        // Traitement des données soumises (si elles existent) et mise à jour de l'objet $topic.
        $form->handleRequest($request);
    
        // Vérifie si le formulaire a été soumis et si les données sont valides.
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupération de l'entity manager de Doctrine pour gérer la persistance.
            $entityManager = $this->getDoctrine()->getManager();
            
            // Indique à Doctrine de "surveiller" l'objet $topic (préparation pour la sauvegarde).
            $entityManager->persist($topic);
            
            // Exécute la requête pour insérer le topic dans la base de données.
            $entityManager->flush();
    
            // Redirige l'utilisateur vers la page d'affichage du topic qu'il vient de créer.
            return $this->redirectToRoute('app_topic_show', ['id' => $topic->getId()]);
        }
    
        // Si le formulaire n'a pas été soumis ou que les données ne sont pas valides, 
        // on affiche le formulaire pour que l'utilisateur puisse le remplir.
        return $this->render('topic/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    #[Route('/topic/{id}/delete', name: 'delete_topic')]
    public function delete(ManagerRegistry $doctrine, Topic $topic): Response
    {
        // Récupérer l'utilisateur actuellement connecté
        $currentUser = $this->getUser();
        
        // Vérifier si l'utilisateur est connecté
        if (!$currentUser) {
            throw new AccessDeniedException('Vous devez être connecté pour supprimer un topic.');
        }
        
        // Vérifier si l'utilisateur actuel est l'auteur du topic
        if ($currentUser !== $topic->getUser()) {
            throw new AccessDeniedException('Vous n\'avez pas le droit de supprimer un topic qui ne vous appartient pas.');
        }
        
        // Récupération de l'Entity Manager de Doctrine pour effectuer des opérations sur la base de données
        $entityManager = $doctrine->getManager();
        
        // Récupérer tous les posts associés à ce topic
        $posts = $topic->getPosts();
        
        // Boucle sur chaque post pour le supprimer
        foreach ($posts as $post) {
            $entityManager->remove($post);
        }
        
        // Suppression du topic lui-même
        $entityManager->remove($topic);
        // Appliquer les modifications (suppressions) à la base de données
        $entityManager->flush();
        
        // Redirection vers la page de la catégorie après la suppression du topic
        return $this->redirectToRoute('app_categorie');
    }
    
}
