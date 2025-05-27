<?php

namespace App\Repository;

use App\Entity\NotificationSubscriber;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<NotificationSubscriber>
 *
 * Repository pour gérer les abonnés aux notifications.
 */
class NotificationSubscriberRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NotificationSubscriber::class);
    }

    /**
     * Trouve un abonné par son email.
     */
    public function findOneByEmail(string $email): ?NotificationSubscriber
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * Ajoute un nouvel abonné.
     * @param NotificationSubscriber $subscriber
     * @param bool $flush
     */
    public function save(NotificationSubscriber $subscriber, bool $flush = true): void
    {
        $this->_em->persist($subscriber);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * Supprime un abonné.
     * @param NotificationSubscriber $subscriber
     * @param bool $flush
     */
    public function remove(NotificationSubscriber $subscriber, bool $flush = true): void
    {
        $this->_em->remove($subscriber);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
