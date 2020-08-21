<?php


namespace App\Entity;

use App\Repository\GameTypeRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GameTypeRepository::class)
 */
class GameType
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @var string
     * @ORM\Column(type="text")
     */
    private $rules;

    /** @var int
     * @ORM\Column(type="integer")
     */
    private $minRatingForMasterclass;

    /** @var Collection
     * @ORM\ManyToOne(targetEntity="RatingPoints", inversedBy="gameType", cascade={"persist"})
     */
    private $ratings;

    /** @var Collection
     * @ORM\ManyToOne(targetEntity="Masterclass", inversedBy="gameType", cascade={"persist"})
     */
    private $masterclasses;

    /** @var Collection
     * @ORM\ManyToOne(targetEntity="Tournament", inversedBy="gameType", cascade={"persist"})
     */
    private $tournaments;

    public function __construct(string $rules, int $minRatingForMasterclass)
    {
        $this->rules = $rules;
        $this->minRatingForMasterclass;
    }

    public function getRules(): string
    {
        return $this->rules;
    }

    public function setRules(string $rules): void
    {
        $this->rules = $rules;
    }

    public function getMinRatingForMasterclass(): int
    {
        return $this->minRatingForMasterclass;
    }

    public function setMinRatingForMasterclass(int $minRatingForMasterclass): void
    {
        $this->minRatingForMasterclass = $minRatingForMasterclass;
    }

    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function getMasterclasses(): Collection
    {
        return $this->masterclasses;
    }
}