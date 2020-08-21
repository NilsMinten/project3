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

    /**
     * @var GameType
     * @ORM\OneToMany(targetEntity="GameType", mappedBy="masterclasses", cascade={"persist"})
     */
    private $gameType;

    /**
     * @var Collection
     * @ORM\ManyToMany(targetEntity="User", mappedBy="masterclasses", cascade={"persist"})
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

    public function __construct(GameType $gameType, int $minimumRating, int $maximumMembers)
    {
        $this->gameType = $gameType;
        $this->minimumRating = $minimumRating;
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
}