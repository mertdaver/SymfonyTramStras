<?php

namespace App\Controller;

use App\Entity\Alerte;
use App\Repository\AlerteRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AlerteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(AlerteRepository $alertRepository): Response
    {
        $latestAlert = $alertRepository->findOneBy([], ['id' => 'DESC']);
        
        return $this->render('base.html.twig', [
            'latestAlert' => $latestAlert
        ]);
    }

    #[Route('/alerte', name: 'get_alerte', methods: ["GET"])]
    public function getAlerte(CategorieRepository $categorieRepository, AlerteRepository $alertRepository): Response
    {
        $categories = $categorieRepository->findAll();
        $latestAlert = $alertRepository->findOneBy([], ['id' => 'DESC']);

        return $this->render('alerte/index.html.twig', [
            'categories' => $categories,
            'latestAlert' => $latestAlert
        ]);
    }

    #[Route('/alerte', name: 'alerte', methods: ["POST"])]
    public function sendAlerte(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $data = $request->request->all();
        $user = $security->getUser();

        $alerte = new Alerte();
        $alerte->setLigne($data['ligne']);
        $alerte->setAlerteDate(new \DateTime());
        $alerte->setSens($data['sens']);
        $alerte->setUser($this->getUser());

        $entityManager->persist($alerte);
        $entityManager->flush();

        return $this->redirectToRoute('confirmation', [
            'latestAlert' => $alerte
        ]);
    }

    #[Route('/confirmation', name: 'confirmation', methods: ["GET"])]
    public function confirmation(Request $request): Response
    {
        $latestAlert = $request->query->get('latestAlert');

        return $this->render('alerte/confirmation.html.twig', [
            'latestAlert' => $latestAlert
        ]);
    }

    #[Route('/get-latest-alert', name: 'get_latest_alert', methods: ['GET'])]
    public function latestAlert(AlerteRepository $alerteRepository): Response
    {
        $latestAlert = $alerteRepository->findLatestAlert();
        
        $data = [
            'id' => $latestAlert->getId(),
            'ligne' => $latestAlert->getLigne(),
            'alerteDate' => $latestAlert->getAlerteDate()->format('Y-m-d H:i:s'),
            'sens' => $latestAlert->getSens(),
            'user' => [
                'id' => $latestAlert->getUser()->getId(),
                'username' => $latestAlert->getUser()->getPseudo()
            ]
        ];

        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/getAlertDetails/{alertId}', name: 'get_alert_details')]
    public function getAlertDetails(int $alertId, AlerteRepository $alerteRepository): JsonResponse
    {
        $alerte = $alerteRepository->find($alertId);
    
        if (!$alerte) {
            return new JsonResponse(['error' => 'Alerte non trouvée'], 404);
        }
    
        $alerteData = [
            'alertId' => $alerte->getId(),
            'ligne' => $alerte->getLigne(),
            'sens' => $alerte->getSens(),
            'user' => $alerte->getUser()->getPseudo(),
            'alerteDate' => $alerte->getAlerteDate()->format('Y-m-d H:i:s'),
        ];
    
        return new JsonResponse($alerteData);
    }

    #[Route('getLatestAlertId', name: 'get_latest_alert_id')]
    public function getLatestAlertId(AlerteRepository $repository): JsonResponse
    {
        $result = $repository->findLatestAlertId();
        $alertId = $result ? $result['id'] : null;
        return new JsonResponse(['id' => $alertId]);
    }

    #[Route('/latest-alert', name: 'latest_alert')]
    public function getLatestAlertInfo(AlerteRepository $alerteRepository): JsonResponse
    {
        $latestAlert = $alerteRepository->findLatestAlert();

        if (!$latestAlert) {
            return new JsonResponse(['error' => 'Aucune alerte trouvée'], 404);
        }

        $data = [
            'id' => $latestAlert->getId(),
            'ligne' => $latestAlert->getLigne(),
            'alerteDate' => $latestAlert->getAlerteDate()->format('Y-m-d H:i:s'),
            'sens' => $latestAlert->getSens(),
            'user' => [
                'id' => $latestAlert->getUser()->getId(),
                'username' => $latestAlert->getUser()->getPseudo()
            ]
        ];

        return new JsonResponse($data);
    }
}