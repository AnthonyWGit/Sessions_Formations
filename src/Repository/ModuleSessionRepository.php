<?php

namespace App\Repository;

use App\Entity\ModuleSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

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
}
