<?php

namespace App\Service;

use App\Entity\User;
use App\Entity\Alerte;
use App\Entity\UserNotification;
use App\Repository\UserRepository;  
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class NotificationService
{
    private $entityManager;
    private $userRepository;  

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)  
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;  
    }

    public function sendAlertNotification(Alerte $alerte)
    {
        $alertUser = $alerte->getUser();

        if (!$alertUser) {
            // Si l'utilisateur est null, lance une exception indiquant qu'il doit se connecter
            throw new Exception('Veuillez vous connecter pour continuer.');
        }

        $users = $this->userRepository->findAllUsersExcept($alertUser);
    
        foreach ($users as $user) {
            $notification = new UserNotification();
            $notification->setUser($user);
            $notification->setMessage('Une nouvelle alerte a été créée : ' . $alerte->getLigne(). $alerte->getSens());
            
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
