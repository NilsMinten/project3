<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TournamentRepository;

/**
 * @ORM\Entity(repositoryClass=TournamentRepository::class)
 */
class Tournament
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var GameType
     * @ORM\OneToMany(targetEntity="GameType", mappedBy="tournaments", cascade={"persist"})
     */
    private $gameType;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="User", mappedBy="tournaments", cascade={"persist"})
     */
    private $visitors;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $priceMoney;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $maximumMembers;

    public function __construct(GameType $gameType, int $priceMoney, int $maximumMembers)
    {
        $this->gameType = $gameType;
        $this->priceMoney = $priceMoney;
        $this->maximumMembers = $maximumMembers;

        $this->visitors = new ArrayCollection();
    }

    public function getGameType(): GameType
    {
        return $this->gameType;
    }

    public function getVisitors(): Collection
    {
        return $this->visitors;
    }

    public function addVisitor(User $user): void
    {
        $this->visitors->add($user);
    }

    public function removeVisitor(User $user): void
    {
        $this->visitors->remove($user);
    }

    public function getPriceMoney(): int
    {
        return $this->priceMoney;
    }

    public function setPriceMoney(int $priceMoney): void
    {
        $this->priceMoney = $priceMoney;
    }

    public function getMaximumMembers(): int
    {
        return $this->maximumMembers;
    }

    public function setMaximumMembers(int $maximumMembers): void
    {
        $this->maximumMembers = $maximumMembers;
    }
}