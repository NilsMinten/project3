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

    public function save(Tournament $user) {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function delete(Tournament $user) {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}