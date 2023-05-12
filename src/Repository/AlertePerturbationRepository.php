<?php

namespace App\Repository;

use App\Entity\AlertePerturbation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<AlertePerturbation>
 *
 * @method AlertePerturbation|null find($id, $lockMode = null, $lockVersion = null)
 * @method AlertePerturbation|null findOneBy(array $criteria, array $orderBy = null)
 * @method AlertePerturbation[]    findAll()
 * @method AlertePerturbation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlertePerturbationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AlertePerturbation::class);
    }

    public function save(AlertePerturbation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(AlertePerturbation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return AlertePerturbation[] Returns an array of AlertePerturbation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?AlertePerturbation
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
