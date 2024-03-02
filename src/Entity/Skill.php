<?php

namespace App\Entity;

use App\Trait\Action;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "skills")]
#[ORM\InheritanceType("SINGLE_TABLE")]
#[ORM\DiscriminatorColumn(name: "type", type: Types::STRING)]
#[ORM\DiscriminatorMap(
    [
        RapidStrike::TYPE => RapidStrike::class,
        MagicShield::TYPE => MagicShield::class,
        Skill::TYPE => Skill::class
    ]
)]
class Skill
{
    use Action;

    public const string NAME = "Attack";
    public const string TYPE = "strike";
    public const int LUCK = 0;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int|null $id;

    #[ORM\Column(name: "name", type: Types::STRING, length: 255, unique: true, nullable: false)]
    private string $name = self::NAME;

    #[ORM\ManyToOne(targetEntity: Player::class, inversedBy: "skills")]
    private Player $player;

    #[ORM\Column(name: "activated", type: Types::BOOLEAN, nullable: false)]
    private bool $activated = false;

    private string $type = self::TYPE;

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

    public function setPlayer(Player $player): self
    {
        $this->player = $player;

        return $this;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function setActivated(bool $activated): self
    {
        $this->activated = $activated;

        return $this;
    }

    public function isActivated(): bool
    {
        return $this->activated;
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
}