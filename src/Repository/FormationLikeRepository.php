<?php

namespace App\Repository;

use App\Entity\FormationLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FormationLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormationLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormationLike[]    findAll()
 * @method FormationLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FormationLike::class);
    }

    // /**
    //  * @return FormationLike[] Returns an array of FormationLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormationLike
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
