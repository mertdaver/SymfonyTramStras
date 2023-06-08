<?php

namespace App\Controller;

use App\Entity\Topic;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopicController extends AbstractController
{
    #[Route('/topic', name: 'app_topic')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $topic = $doctrine->getRepository(Topic::class)->findAll();
        
        return $this->render('topic/index.html.twig', [
            'topic' => $topic ,
        ]);
    }

    #[Route('/topic/{id}', name: 'show_topic')]

    public function show(Topic $topic): Response
    {
        return $this->render('topic/show.html.twig', [
            'topic' => $topic
        ]);
    }
}
