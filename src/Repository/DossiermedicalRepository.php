<?php

namespace App\Repository;

use App\Entity\Dossiermedical;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dossiermedical>
 *
 * @method Dossiermedical|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dossiermedical|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dossiermedical[]    findAll()
 * @method Dossiermedical[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DossiermedicalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dossiermedical::class);
    }
     public function getChronicDiseaseStatistics(): array
    {
        $query = $this->createQueryBuilder('d')
            ->select('d.maladie_chronique, COUNT(d.id) as count')
            ->groupBy('d.maladie_chronique')
            ->getQuery();

        $results = $query->getResult();

        $statistics = [];
        foreach ($results as $result) {
            $statistics[$result['maladie_chronique']] = $result['count'];
        }

        return $statistics;
    }
}

//    /**
//     * @return Dossiermedical[] Returns an array of Dossiermedical objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('d.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Dossiermedical
//    {
//        return $this->createQueryBuilder('d')
//            ->andWhere('d.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

