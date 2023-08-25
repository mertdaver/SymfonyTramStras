<?php

namespace App\Controller;

use App\Entity\Plan;
use App\Entity\Subscription;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AccountController extends AbstractController
{
    #[Route('/account', name: 'app_account')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $plans = $doctrine->getRepository(Plan::class)->findAll();
        $activeSub = $doctrine->getRepository(Subscription::class)->findActiveSub($this->getUser()->getId());

        return $this->render('account/index.html.twig', [
            'plans' => $plans,
            'activeSub' => $activeSub,
        ]);
    }

    #[Route('/getPseudo/{userId}', name: 'get_user_pseudo', methods: ['GET'])]
    public function getPseudo(UserRepository $userRepository, int $userId): JsonResponse
    {
        $user = $userRepository->find($userId);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], 404);
        }

        return new JsonResponse(['pseudo' => $user->getPseudo()]);
    }
}