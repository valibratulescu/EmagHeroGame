<?php

namespace Tests\Emagia\Hero\Players;

use Emagia\Hero\Factory\PlayerFactory;
use Emagia\Hero\Handlers\Player;
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    /**
     * @var Player
     */
    protected $player;

    protected function setUp()
    {
        $player = PlayerFactory::createPlayer([
            "name"  => "WILDBEAST",
            "stats" => [
                "health"   => [
                    "min" => 55,
                    "max" => 84,
                ],
                "strength" => [
                    "min" => 67,
                    "max" => 83,
                ],
                "defence"  => [
                    "min" => 40,
                    "max" => 50,
                ],
                "speed"    => [
                    "min" => 42,
                    "max" => 52,
                ],
                "luck"     => [
                    "min" => 15,
                    "max" => 28,
                ],
            ],
        ]);

        $this->player = $player;
    }

    public function testName()
    {
        self::assertNotEmpty($this->player->getName(), "Name not set for player");
    }

    public function testStats()
    {
        $stats = $this->player->getStats(false);

        self::assertJson($this->player->getStats(), "Invalid format for stats");

        self::assertArrayHasKey("health", $stats, "Health not set for player");
        self::assertArrayHasKey("strength", $stats, "Strength not set for player");
        self::assertArrayHasKey("defence", $stats, "Defence not set for player");
        self::assertArrayHasKey("speed", $stats, "Speed not set for player");
        self::assertArrayHasKey("luck", $stats, "Luck not set for player");

        self::assertNotEmpty($stats["health"], "Health is set but its value is invalid");
        self::assertNotEmpty($stats["strength"], "Strength is set but its value is invalid");
        self::assertNotEmpty($stats["defence"], "Defence is set but its value is invalid");
        self::assertNotEmpty($stats["speed"], "Speed is set but its value is invalid");
        self::assertNotEmpty($stats["luck"], "Luck is set but its value is invalid");
    }

    public function testHealth()
    {
        self::assertGreaterThanOrEqual(55, $this->player->getStatValue("health"), "Health is too low");
        self::assertLessThanOrEqual(84, $this->player->getStatValue("health"), "Health is too high");
    }

    public function testStrength()
    {
        self::assertGreaterThanOrEqual(67, $this->player->getStatValue("strength"), "Strength is too low");
        self::assertLessThanOrEqual(83, $this->player->getStatValue("strength"), "Strength is too high");
    }

    public function testDefence()
    {
        self::assertGreaterThanOrEqual(40, $this->player->getStatValue("defence"), "Defence is too low");
        self::assertLessThanOrEqual(50, $this->player->getStatValue("defence"), "Defence is too high");
    }

    public function testSpeed()
    {
        self::assertGreaterThanOrEqual(42, $this->player->getStatValue("speed"), "Speed is too low");
        self::assertLessThanOrEqual(52, $this->player->getStatValue("speed"), "Speed is too high");
    }

    public function testLuck()
    {
        self::assertGreaterThanOrEqual(15, $this->player->getStatValue("luck"), "Luck is too low");
        self::assertLessThanOrEqual(28, $this->player->getStatValue("luck"), "Luck is too high");
    }
}
