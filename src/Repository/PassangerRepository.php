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
}
