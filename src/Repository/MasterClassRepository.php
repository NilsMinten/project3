<?php


namespace App\Repository;


use App\Entity\Masterclass;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class MasterClassRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Masterclass::class);
    }

    public function save(Masterclass $user) {
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function delete(Masterclass $user) {
        $this->_em->remove($user);
        $this->_em->flush();
    }
}