<?php

namespace App\Repository;

use App\Entity\ModuleSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModuleSession>
 *
 * @method ModuleSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method ModuleSession|null findOneBy(array $criteria, array $orderBy = null)
 * @method ModuleSession[]    findAll()
 * @method ModuleSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ModuleSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModuleSession::class);
    }


    public function filterModulesBySearchTerm($searchTerm)
    {
        return $this->createQueryBuilder('m')
            ->where('m.nom LIKE :searchTerm')
            ->setParameter('searchTerm', '%' . $searchTerm . '%')
            ->getQuery()
            ->getResult();
    }
//    /**
//     * @return ModuleSession[] Returns an array of ModuleSession objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ModuleSession
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
