<?php

namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use App\Service\NotificationService;
use Symfony\Bundle\SecurityBundle\Security;
use Twig\Environment;

class NotificationListener
{
    private $notificationService;
    private $security;
    private $twig;

    public function __construct(NotificationService $notificationService, Security $security, Environment $twig)
    {
        $this->notificationService = $notificationService;
        $this->security = $security;
        $this->twig = $twig;
    }

    public function onKernelRequest(RequestEvent $event)
    {
        if ($event->isMainRequest()) {
            $user = $this->security->getUser();

            if ($user) {
                $notifications = $this->notificationService->getNotificationsForUser($user);

                $this->twig->addGlobal('notifications', $notifications);
            }
        }
    }
}