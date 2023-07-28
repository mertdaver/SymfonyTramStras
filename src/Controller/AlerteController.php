<?php

namespace App\Controller;

use App\Entity\Alerte;
use App\Repository\AlerteRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function sendAlerte(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $data = $request->request->all();
        $user = $security->getUser();
    
        $ligne = $data['ligne'] ?? null;
        $sens = $data['sens'] ?? null;
    
        // Création d'une nouvelle alerte
        $alerte = new Alerte();
        $alerte->setLigne($ligne);
        $alerte->setSens($sens);
        $alerte->setUser($user); // Passer l'objet User directement à setUser()
        $alerte->setAlerteDate(new \DateTime());
    
        // Enregistrement de l'alerte dans la base de données
        $entityManager->persist($alerte);
        $entityManager->flush();
    
        return $this->redirectToRoute('confirmation');
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


    // https://waytolearnx.com/2022/09/creer-un-systeme-de-notification-avec-php-mysql-et-ajax.html
    #[Route('/get-unread-alerts', name: 'get_unread_alerts', methods: ['POST'])]
public function getUnreadAlerts(Request $request, AlerteRepository $alerteRepository, EntityManagerInterface $entityManager): JsonResponse
{
    if ($request->request->get('vue')) {
        // Récupérer les alertes non lues et les marquer comme lues
        $unreadAlerts = $alerteRepository->findBy(['vue' => 0]);
        foreach ($unreadAlerts as $alert) {
            $alert->setVue(1);
            $entityManager->persist($alert);
        }
        $entityManager->flush();

        // Récupérer les 4 dernières alertes
        $latestAlerts = $alerteRepository->findBy([], ['id' => 'DESC'], 1);

        $output = '';
        if (!empty($latestAlerts)) {
            foreach ($latestAlerts as $alert) {
                $output .= '
                <li>
                <a href="#">
                <b>' . $alert->getLigne() . '</b><br />
                <small>' . $alert->getSens() . '</small>
                </a>
                </li>';
            }
        } else {
            $output .= '<li><a href="#">Aucune alerte trouvée</a></li>';
        }

        $new_alert_count = count($alerteRepository->findBy(['vue' => 0]));

        $data = [
            'notification' => $output,
            'new_notification' => $new_alert_count,
        ];

        return new JsonResponse($data);
    }
}



}
