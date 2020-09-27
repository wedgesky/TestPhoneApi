<?php

namespace App\Repository;

use App\Entity\TestPhone;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TestPhone|null find($id, $lockMode = null, $lockVersion = null)
 * @method TestPhone|null findOneBy(array $criteria, array $orderBy = null)
 * @method TestPhone[]    findAll()
 * @method TestPhone[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TestPhoneRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TestPhone::class);
    }

    // /**
    //  * @return TestPhone[] Returns an array of TestPhone objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TestPhone
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
