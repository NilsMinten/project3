<?php


namespace App\Repository;


use App\Entity\Tournament;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TournamentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tournament::class);
    }

    public function findUpcomming(int $limit = 2) {
        return $this->createQueryBuilder('t')
            ->where('t.startTime > :currentTime')
            ->setParameter('currentTime', new \DateTime())
            ->orderBy('t.startTime')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function save(Tournament $user) {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function delete(Tournament $user) {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}