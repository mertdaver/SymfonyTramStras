<?php

namespace App\Repository;

use Psr\Log\LoggerInterface;
use App\Entity\UserNotification;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<UserNotification>
 *
 * @method UserNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserNotification[]    findAll()
 * @method UserNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserNotificationRepository extends ServiceEntityRepository
{
    private $logger;

    public function __construct(ManagerRegistry $registry, LoggerInterface $logger)
    {
        parent::__construct($registry, UserNotification::class);
        $this->logger = $logger;
    }

    public function findUnreadByUser($user)
    {
        $this->logger->info('Executing findUnreadByUser query for user: ' . $user->getPseudo());

        return $this->createQueryBuilder('a')
            ->where('a.user = :user')
            ->andWhere('a.isRead = false') 
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }
}