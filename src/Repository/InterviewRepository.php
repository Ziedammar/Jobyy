<?php

namespace App\Repository;

use App\Data\SearchData;
use App\Entity\Interview;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Interview|null find($id, $lockMode = null, $lockVersion = null)
 * @method Interview|null findOneBy(array $criteria, array $orderBy = null)
 * @method Interview[]    findAll()
 * @method Interview[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InterviewRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Interview::class);
    }

    public function sortByDate(){

        $qb = $this->createQueryBuilder('interview_date') ; 
        $qb ->select( 'c' )
            ->from('App\Entity\Interview' ,'c' )
            ->orderBy('c.date_temps' ,'ASC');
        return $qb->getQuery()->getResult() ; 

    }
    public function findSearch( SearchData $data){
        $query = $this->createQueryBuilder(('i'))
                      ->select('i');

        if(!empty($data->c)){
            $query=$query
            ->andWhere('i.abreviation LIKE :c')
            ->setParameter('c' ,"%{$data->c}%");

        }
        if(!empty($data->min)){
            $query=$query
            ->andWhere('i.date_temps >= :min')
            ->setParameter('min' ,$data->min);

        }
        if(!empty($data->max)){
            $query=$query
            ->andWhere('i.date_temps <= :max')
            ->setParameter('max' ,$data->max);

        }
   
    


        return $query->getQuery()->getResult() ;
     

    }

    // /**
    //  * @return Interview[] Returns an array of Interview objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Interview
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
