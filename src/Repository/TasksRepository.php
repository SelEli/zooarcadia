<?php

namespace App\Repository;

use App\Entity\Tasks;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TasksRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tasks::class);
    }

    /**
     * @return Tasks[] Returns an array of Tasks objects
     */
    public function findByUser(User $user): array
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Tasks[] Returns an array of all Tasks objects with user information
     */
    public function findAllWithUserInfo(): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.user', 'u')
            ->addSelect('u')
            ->getQuery()
            ->getResult();
    }
}
