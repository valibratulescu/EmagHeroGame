<?php

namespace App\Entity;

use App\Trait\Action;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "players")]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: Types::STRING)]
#[ORM\DiscriminatorMap(
    [
        Hero::TYPE => Hero::class,
        Beast::TYPE => Beast::class,
        Player::TYPE => Player::class
    ]
)]
class Player
{
    use Action;

    public const string TYPE = "player";

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id;

    #[ORM\Column(name: "name", type: Types::STRING, length: 255, nullable: false)]
    private string $name;

    #[ORM\Column(name: "health", type: Types::INTEGER, nullable: false)]
    private int $health;

    #[ORM\Column(name: "strength", type: Types::INTEGER, nullable: false)]
    private int $strength;

    #[ORM\Column(name: "defence", type: Types::INTEGER, nullable: false)]
    private int $defence;

    #[ORM\Column(name: "speed", type: Types::INTEGER, nullable: false)]
    private int $speed;

    #[ORM\Column(name: "luck", type: Types::INTEGER, nullable: false)]
    private int $luck;

    #[ORM\OneToMany(targetEntity: Skill::class, mappedBy: "player", cascade: ["persist", "remove"])]
    private Collection $skills;

    private string $type = self::TYPE;

    public function __construct()
    {
        $this->skills = new ArrayCollection();
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setHealth(int $health): self
    {
        $this->health = $health;

        return $this;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function setStrength(int $strength): self
    {
        $this->strength = $strength;

        return $this;
    }

    public function getStrength(): int
    {
        return $this->strength;
    }

    public function setDefence(int $defence): self
    {
        $this->defence = $defence;

        return $this;
    }

    public function getDefence(): int
    {
        return $this->defence;
    }

    public function setSpeed(int $speed): self
    {
        $this->speed = $speed;

        return $this;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function setLuck(int $luck): self
    {
        $this->luck = $luck;

        return $this;
    }

    public function getLuck(): int
    {
        return $this->luck;
    }

    public function addSkill(Skill $skill): self
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
            $skill->setPlayer($this);
        }

        return $this;
    }

    public function getSkills(): Collection
    {
        return $this->skills;
    }

    public function filterSkillsByAction(string $action): Collection
    {
        if (!$this->skills->isEmpty()) {
            return $this->skills->filter(function (Skill $skill) use ($action) {
                return $skill->getAction()->value === constant(\App\Config\Action::class . "::{$action}")->value;
            });
        }

        return $this->skills;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return json_encode(
            [
                "health" => $this->health,
                "strength" => $this->strength,
                "defence" => $this->defence,
                "speed" => $this->speed,
                "luck" => $this->luck,
            ],
            JSON_PRETTY_PRINT
        );
    }
}