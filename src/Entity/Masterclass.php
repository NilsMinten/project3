<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MasterClassRepository;

/**
 * @ORM\Entity(repositoryClass=MasterClassRepository::class)
 */
class Masterclass
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
     * @ORM\ManyToOne(targetEntity="GameType", inversedBy="masterclasses", cascade={"persist"})
     */
    private $gameType;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="User", inversedBy="masterclasses", cascade={"persist"})
     */
    private $visitors;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $minimumRating;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $maximumMembers;

    /** @var \DateTime
     * @ORM\Column(type="datetime")
     */
    private $startTime;

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

    public function getMinimumRating(): int
    {
        return $this->minimumRating;
    }

    public function setMinimumRating(int $minimumRating): void
    {
        $this->minimumRating = $minimumRating;
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
}