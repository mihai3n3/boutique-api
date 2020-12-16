<?php

namespace App\Repository;

use App\Entity\ProductGallery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProductGallery|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductGallery|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductGallery[]    findAll()
 * @method ProductGallery[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductGalleryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProductGallery::class);
    }
}