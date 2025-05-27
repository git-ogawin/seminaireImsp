<?php

namespace App\Repository;

use App\Entity\Seminar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seminar>
 */
class SeminarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seminar::class);
    }

    public function findAllOrderedByDate()
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.date', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findUpcomingValidated(int $daysAhead = 7): array
{
    $today = new \DateTimeImmutable();
    $dateLimit = $today->modify("+{$daysAhead} days")->setTime(23, 59, 59);

    return $this->createQueryBuilder('s')
        ->where('s.statut = :statut')
        ->andWhere('s.date >= :now')
        ->andWhere('s.date <= :dateLimit')
        ->setParameter('statut', 'validé')
        ->setParameter('now', $today)
        ->setParameter('dateLimit', $dateLimit)
        ->orderBy('s.date', 'ASC')
        ->getQuery()
        ->getResult();
}

}
