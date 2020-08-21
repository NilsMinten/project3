<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\RatingPointRepository;

/**
 * @ORM\Entity(repositoryClass=RatingPointRepository::class)
 */
class RatingPoints
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="rating", cascade={"persist"})
     */
    private $user;

    /**
     * @var GameType
     * @ORM\OneToMany(targetEntity="GameType", mappedBy="ratings", cascade={"persist"})
     */
    private $gameType;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $rating;

    public function __construct(User $user, GameType $gameType, int $rating = null)
    {
        $this->user = $user;
        $this->gameType = $gameType;
        $this->rating = $rating ?? 0;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getGameType(): GameType
    {
        return $this->gameType;
    }

    public function getRating(): int
    {
        return $this->rating;
    }

    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }
}