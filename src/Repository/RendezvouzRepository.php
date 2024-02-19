<?php

namespace App\Repository;

use App\Entity\Rendezvouz;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Rendezvouz>
 *
 * @method Rendezvouz|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rendezvouz|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rendezvouz[]    findAll()
 * @method Rendezvouz[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RendezvouzRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rendezvouz::class);
    }

//    /**
//     * @return Rendezvouz[] Returns an array of Rendezvouz objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Rendezvouz
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
