<?php

namespace App\Repository;

use App\Entity\UserApi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method UserApi|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserApi|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserApi[]    findAll()
 * @method UserApi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserApiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserApi::class);
    }
}
