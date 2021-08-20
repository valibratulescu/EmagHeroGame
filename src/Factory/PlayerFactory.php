<?php

namespace Emagia\Hero\Factory;

use Emagia\Hero\Handlers\Player;
use Emagia\Hero\Utils\MathUtils;
use Exception;

class PlayerFactory
{
    /**
     * @param array $info
     *
     * @return Player
     *
     * @throws Exception
     */
    public static function createPlayer(array $info): Player
    {
        $name = $info["name"];

        $stats  = array_key_exists("stats", $info) ? self::createStats($info["stats"]) : [];
        $skills = array_key_exists("skills", $info) ? SkillFactory::createSkills($info["skills"]) : [];

        return new Player($name, $stats, $skills);
    }

    /**
     * Initializes player stats based on their min-max range.
     *
     * @param array $stats
     *
     * @return array
     */
    private static function createStats(array $stats): array
    {
        $data = [];

        foreach ($stats as $property => $item) {
            $data[$property] = MathUtils::generateRandomNumber($item["min"], $item["max"]);
        }

        return $data;
    }
}
