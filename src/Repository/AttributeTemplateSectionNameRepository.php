<?php

namespace App\Repository;

use App\Entity\AttributeTemplateSectionName;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AttributeTemplateSectionName|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttributeTemplateSectionName|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttributeTemplateSectionName[]    findAll()
 * @method AttributeTemplateSectionName[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributeTemplateSectionNameRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AttributeTemplateSectionName::class);
    }

    // /**
    //  * @return AttributeTemplateSectionName[] Returns an array of AttributeTemplateSectionName objects
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
    public function findOneBySomeField($value): ?AttributeTemplateSectionName
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
