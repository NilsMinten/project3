<?php


namespace App\Entity;

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

    /** @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var GameType
     * @ORM\ManyToOne(targetEntity="GameType", inversedBy="tournaments", cascade={"persist"})
     */
    private $gameType;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="User", inversedBy="tournaments", cascade={"persist"})
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

    /** @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $startTime;

    /** @var int
     * @ORM\Column(type="integer")
     */
    private $tables;

    /** @var string
     * @ORM\Column(type="json")
     */
    private $runningStatus;

    public function getId()
    {
        return $this->id;
    }

    public function getGameType(): ?GameType
    {
        return $this->gameType;
    }

    public function getVisitors(): ?Collection
    {
        return $this->visitors;
    }

    public function setVisitors(Collection $visitors): void
    {
        $this->visitors = $visitors;
    }

    public function addSingleVisitor(User $user): void
    {
        $this->visitors->add($user);
    }

    public function removeVisitor(User $user): void
    {
        $this->visitors->removeElement($user);
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setGameType(GameType $gameType): void
    {
        $this->gameType = $gameType;
    }

    public function getStartTime(): ?\DateTime
    {
        return $this->startTime;
    }

    public function setStartTime(\DateTime $startTime): void
    {
        $this->startTime = $startTime;
    }

    public function getTables(): int
    {
        return $this->tables;
    }

    public function setTables(int $tables): void
    {
        $this->tables = $tables;
    }

    public function getRunningStatus(): ?\stdClass
    {
        return json_decode($this->runningStatus);
    }

    public function setRunningStatus(array $runningStatus): void
    {
        $this->runningStatus = json_encode($runningStatus);
    }
}