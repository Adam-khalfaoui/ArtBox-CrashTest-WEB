<?php

namespace App\Repository;

use App\Entity\Feedback;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Feedback|null find($id, $lockMode = null, $lockVersion = null)
 * @method Feedback|null findOneBy(array $criteria, array $orderBy = null)
 * @method Feedback[]    findAll()
 * @method Feedback[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class FeedbackRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Feedback::class);
    }

    function tri_asc()
    {
        return $this->createQueryBuilder('feedback')
            ->orderBy('feedback.contenue ', 'ASC')
            ->getQuery()->getResult();
    }

    function tri_desc()
    {
        return $this->createQueryBuilder('feedback')
            ->orderBy('feedback.contenue ', 'DESC')
            ->getQuery()->getResult();
    }
}