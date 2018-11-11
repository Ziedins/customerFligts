<?php

namespace App\Repository;

use App\Entity\Passanger;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Passanger|null find($id, $lockMode = null, $lockVersion = null)
 * @method Passanger|null findOneBy(array $criteria, array $orderBy = null)
 * @method Passanger[]    findAll()
 * @method Passanger[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PassangerRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Passanger::class);
    }

    // /**
    //  * @return Passanger[] Returns an array of Passanger objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Passanger
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
