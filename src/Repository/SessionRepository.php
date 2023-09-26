<?php

namespace App\Repository;

use App\Entity\Session;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Session>
 *
 * @method Session|null find($id, $lockMode = null, $lockVersion = null)
 * @method Session|null findOneBy(array $criteria, array $orderBy = null)
 * @method Session[]    findAll()
 * @method Session[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Session::class);
    }


    public function findSessionsAVenir(): array

    {
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateSessionDebut > :now')
            ->setParameter('now', $now)
            ->orderBy('s.dateSessionDebut', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSessionsEnCours(): array

    {
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateSessionDebut < :now')
            ->andWhere('s.dateSessionFin > :now')
            ->setParameter('now', $now)
            ->orderBy('s.dateSessionDebut', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSessionsFinies(): array

    {
        $now = new \DateTime();
        return $this->createQueryBuilder('s')
            ->andWhere('s.dateSessionFin > :now')
            ->setParameter('now', $now)
            ->orderBy('s.dateSessionDebut', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findNonInscrits($session_id)
    {
        $entityManager = $this->getEntityManager();
        $sub = $entityManager->createQueryBuilder();

        $queryBuilder = $sub;
        // Select all stagiaires from a session where id is a parameter
        $queryBuilder
        ->select("s")
        ->from('App\Entity\Stagiaire', 's')
        ->leftJoin('s.sessions', 'se')
        ->where('se.id = :id');

        $sub = $entityManager->createQueryBuilder();
        // selectring stagiaires NOT IN the last result 
        //We end up having all stagiaires for the session
        $sub
        ->select('st')
        ->from('App\Entity\Stagiaire', 'st')
        ->where($sub->expr()->notIn('st.id', $queryBuilder->getDQL()))
        ->setParameter('id', $session_id)
        ->orderBy('st.nom');
        //get the result
        $query = $sub->getQuery();
        return $query->getResult();
    }

    public function findModulesNonConcernes($session_id)
    {
        $em = $this->getEntityManager();
        $sub = $em->createQueryBuilder();

        $queryBuilder = $sub;

        $queryBuilder
        ->select("s")
        ->from("app\Entity\Programme", "s")
        ->leftJoin("s.session", 'se')
        ->where('se.id = :id');

        $sub = $em->createQueryBuilder();
        $sub
        ->select('m')
        ->from('App\Entity\Programme', 'm')
        ->where($sub->expr()->notIn('m.id', $queryBuilder->getDQL()))
        ->setParameter('id' , $session_id)
        ->orderBy('m.nbjours');

        $query = $sub->getQuery();
        return $query->getResult();
    }


//    /**
//     * @return Session[] Returns an array of Session objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Session
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
