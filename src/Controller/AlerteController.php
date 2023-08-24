<?php

namespace App\Controller;


use App\Entity\Alerte;
use App\Entity\Webhook;
use App\Repository\AlerteRepository;
use App\Service\NotificationService;
use App\Entity\Webhook as AppWebhook;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use \Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class AlerteController extends AbstractController
{
    #[Route('/alerte', name: 'get_alerte', methods: ["GET"])]
    public function getAlerte(CategorieRepository $categorieRepository): Response
    {
        $categories = $categorieRepository->findAll();

        return $this->render('alerte/index.html.twig', [
            'categories' => $categories,
        ]);
    }

    #[Route('/alerte', name: 'alerte', methods: ["POST"])]
    public function sendAlerte(Request $request, EntityManagerInterface $entityManager, Security $security, NotificationService $notificationService): Response
    {
        $data = $request->request->all();
        $user = $security->getUser();

        // Création d'une nouvelle alerte
        $alerte = new Alerte();
        $alerte->setLigne($data['ligne']);
        $alerte->setAlerteDate(new \DateTime());
        $alerte->setSens($data['sens']);
        $alerte->setUser($this->getUser());

        $entityManager->persist($alerte);
        $entityManager->flush();

        // Configurer le webhook
        $webhook = new Webhook();
        $webhook->setUrl('https://example.com/webhook');
        $webhook->setEventType('alerte.created');
        $webhook->setData($data);

        $entityManager->persist($webhook);
        $entityManager->flush();

        // Envoyer une notification aux utilisateurs
        $notificationService->sendAlertNotification($alerte);

        return new Response('Alerte créée', Response::HTTP_CREATED);
    }


    #[Route('/get-unread-notifications', name: 'get_unread_notifications')]
    public function getUnreadNotifications(AlerteRepository $alerteRepository, SerializerInterface $serializer)
    {
        $user = $this->getUser();

        // Supposez que nous avons une méthode appelée findUnreadByUser dans AlerteRepository
        $notifications = $alerteRepository->findUnreadByUser($user);

        // Serialisation des objets Alerte en JSON
        $data = $serializer->serialize($notifications, 'json', ['groups' => 'alerte_read']);

        return new JsonResponse($data, 200, [], true);
    }



    #[Route('/confirmation', name: 'confirmation', methods: ["GET"])]
    public function confirmation(): Response
    {
        return $this->render('alerte/confirmation.html.twig');
    }

    #[Route('/get-latest-alert', name: 'get_latest_alert', methods: ['GET'])]
    public function getLatestAlert(AlerteRepository $alerteRepository): JsonResponse
    {
        // Récupérer la dernière alerte de la base de données
        $latestAlert = $alerteRepository->findLatestAlert();

        if (!$latestAlert) {
            // Return an empty JSON response if no alert is found
            return new JsonResponse([]);
        }

        // Préparer les données à envoyer dans la réponse JSON
        $data = [
            'id' => $latestAlert->getId(),
            'ligne' => $latestAlert->getLigne(),
            'alerteDate' => $latestAlert->getAlerteDate()->format('Y-m-d H:i:s'),
            'sens' => $latestAlert->getSens(),
            // Inclure d'autres propriétés si nécessaire
        ];

        // Renvoyer la réponse JSON avec les dernières données d'alerte
        return new JsonResponse($data);
    }
}
