<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"username", "email"}, message="There is already an account with this username/email")
 */
class User implements UserInterface
{
    public const ROLE_MEMBER = 'ROLE_MEMBER';
    public const ROLE_EMPLOYEE = 'ROLE_EMPLOYEE';
    public const ROLE_ADMIN = 'ROLE_ADMIN';

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [self::ROLE_MEMBER];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /** @var string
     * @ORM\Column(type="string")
     */
    private $email;

    /** @var string
     * @ORM\Column(type="string")
     */
    private $firstName;

    /** @var string
     * @ORM\Column(type="string")
     */
    private $lastName;

    /** @var Collection
     * @ORM\OneToMany(targetEntity="RatingPoints", mappedBy="user", cascade={"persist"})
     */
    private $rating;

    /** @var Collection
     * @ORM\ManyToMany(targetEntity="Masterclass", mappedBy="visitors", cascade={"persist"})
     */
    private $masterclasses;

    /** @var Collection
     * @ORM\ManyToMany(targetEntity="Tournament", mappedBy="visitors", cascade={"persist"})
     */
    private $tournaments;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->rating = new ArrayCollection();
        $this->masterclasses = new ArrayCollection();
        $this->tournaments = new ArrayCollection();
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getRole(): string
    {
        $roles = $this->roles;
        $role = array_values(array_filter($roles, function ($role) {
            return $role !== 'ROLE_USER';
        }));

        return $role[0];
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function setRole(string $role): self
    {
        $this->setRoles([
            'ROLE_USER',
            $role
        ]);

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getRating(): ?Collection
    {
        return $this->rating;
    }

    public function addRating(RatingPoints $ratingPoints) {
        if ($this->rating !== null) {
            $this->rating->add($ratingPoints);

            return;
        }

        $this->rating = new ArrayCollection([$ratingPoints]);
    }

    public function getSingleRating(GameType $gameType): ?RatingPoints
    {
        $rating = array_values(array_filter($this->getRating()->toArray(), function (RatingPoints $rating) use ($gameType) {
            return $rating->getGameType() === $gameType;
        }));

        return count($rating) > 0 ? $rating[0] : null;
    }

    public function getMasterclasses(): Collection
    {
        return $this->masterclasses;
    }

    public function getTournaments(): Collection
    {
        return $this->tournaments;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}
