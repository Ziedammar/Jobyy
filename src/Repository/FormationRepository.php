<?php

namespace App\Repository;

use App\Entity\Formation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Formation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Formation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Formation[]    findAll()
 * @method Formation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Formation::class);
    }

    // /**
    //  * @return Formation[] Returns an array of Formation objects
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
    public function findOneBySomeField($value): ?Formation
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    function listFormationByCat($id){
        return$this->createQueryBuilder('f')
            ->join('f.idcategorie','c')
            ->addSelect('c')
            ->where('c.id=:id')
            ->setParameter('id',$id)
            ->getQuery()->getResult();
    }


    /**
     * retourne le nombre de formations par jour
     *
     */
    public function CountByDate()
    {
        $query=$this->createQueryBuilder('a')
            ->select('SUBSTRING(a.date,1,10) as dateFormations, COUNT(a) as count')
            ->groupBy('dateFormations')
            ;
            return $query->getQuery()->getResult();


    }

    /**
     * retourne le nombre de formations par secteur
     *
     */
    public function CountBySecteur()
    {
        $query=$this->createQueryBuilder('a')
            ->select('SUBSTRING(a.secteur,1,10) as secteurFormations, COUNT(a) as count')
            ->groupBy('secteurFormations')
        ;
        return $query->getQuery()->getResult();


    }

    public function ajax($name)
    {
        return $this->createQueryBuilder('f')
                ->where('f.nom LIKE :nom')
                ->setParameter('nom','%'.$name.'%')
                ->getQuery()
                ->getResult();
    }

}
