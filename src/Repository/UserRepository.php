<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<User>
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Trouve tous les utilisateurs ayant le rôle ROLE_ETUDIANT
     * @return User[]
     */
    public function findByRole(string $role): array
    {
        $qb = $this->createQueryBuilder('u');
        $qb->andWhere('JSON_CONTAINS(u.roles, :role) = 1')
           ->setParameter('role', '"' . $role . '"');

        return $qb->getQuery()->getResult();
    }
}