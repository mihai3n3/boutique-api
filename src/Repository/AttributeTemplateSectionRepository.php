<?php

namespace App\Repository;

use App\Entity\AttributeTemplateSection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttributeTemplateSection|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttributeTemplateSection|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttributeTemplateSection[]    findAll()
 * @method AttributeTemplateSection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributeTemplateSectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttributeTemplateSection::class);
    }

    // /**
    //  * @return AttributeTemplateSection[] Returns an array of AttributeTemplateSection objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AttributeTemplateSection
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
