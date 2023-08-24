<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Alerte;
use App\Entity\UserNotification;
use App\Repository\AlerteRepository;
use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    private $entityManager;
    private $alerteRepository;

    public function __construct(EntityManagerInterface $entityManager, AlerteRepository $alerteRepository)
    {
        $this->entityManager = $entityManager;
        $this->alerteRepository = $alerteRepository;
    }

    public function sendAlertNotification(Alerte $alerte)
    {
        $alertes = $this->alerteRepository->findAllUsersExcept($alerte->getUser());
    
        foreach ($alertes as $alert) {
            $user = $alert->getUser();
            $notification = new UserNotification();
            $notification->setUser($user);
            $notification->setMessage('Une nouvelle alerte a été créée : ' . $alerte->getLigne());
            
            $this->entityManager->persist($notification);
        }
    
        $this->entityManager->flush();
    }
    

    public function getNotificationsForUser(User $user)
    {
        $notificationRepo = $this->entityManager->getRepository(UserNotification::class);
        return $notificationRepo->findBy(['user' => $user]);
    }
}
