<?php

namespace App\Controller;

use App\Entity\Plan;
use App\Entity\User;
use App\Entity\Subscription;
use App\Repository\UserRepository;
use App\Repository\AlerteRepository; 
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Serializer\SerializerInterface;

class AccountController extends AbstractController
{
    /**
    * @IsGranted("ROLE_USER")
    */
    #[Route('/account', name: 'app_account')]
    public function index(ManagerRegistry $doctrine, AlerteRepository $alerteRepository): Response // Ajout de AlerteRepository
    {
        $plans = $doctrine->getRepository(Plan::class)->findAll();
        $activeSub = $doctrine->getRepository(Subscription::class)->findActiveSub($this->getUser()->getId());

        // Ajout de cette partie pour obtenir la dernière alerte
        $latestAlert = $alerteRepository->findLatestAlert();

        $user = $this->getUser();
        if (!$user) {
            // Handle not logged-in scenario, e.g., redirect to login page
            return $this->redirectToRoute('app_login');
        }

        return $this->render('account/index.html.twig', [
            'user' => $user,
            'plans' => $plans,
            'activeSub' => $activeSub,
            'latestAlert' => $latestAlert, // Ajout de cette ligne pour fenêtre modal alerte
        ]);
    }

    #[Route('/getPseudo/{id}', name: 'get_user_pseudo', methods: ['GET'])]
    public function getPseudo(User $user = null): JsonResponse
    {
        if (!$user) {
            return $this->json(['error' => 'Utilisateur non trouvé'], 404);
        }
    
        return $this->json(['pseudo' => $user->getPseudo()]);
    }
    
}
