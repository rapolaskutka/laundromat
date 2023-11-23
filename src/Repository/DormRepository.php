<?php

namespace App\Repository;

use App\Entity\Dorm;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Dorm>
 *
 * @method Dorm|null find($id, $lockMode = null, $lockVersion = null)
 * @method Dorm|null findOneBy(array $criteria, array $orderBy = null)
 * @method Dorm[]    findAll()
 * @method Dorm[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DormRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dorm::class);
    }
}
