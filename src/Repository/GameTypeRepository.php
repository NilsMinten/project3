<?php


namespace App\Repository;


use App\Entity\GameType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class GameTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, GameType::class);
    }

    public function save(GameType $user) {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function delete(GameType $user) {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}