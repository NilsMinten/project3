<?php


namespace App\Repository;


use App\Entity\RatingPoints;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class RatingPointRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RatingPoints::class);
    }

    public function save(RatingPoints $user) {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function delete(RatingPoints $user) {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}