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
