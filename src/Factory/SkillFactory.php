<?php

namespace Emagia\Hero\Factory;

use Emagia\Hero\Handlers\Skill;
use Emagia\Hero\Utils\AutoloaderUtils;
use Exception;

class SkillFactory
{
    /**
     * @var string
     */
    const CLASS_ROOT_PATH = "Skills";

    /**
     * Initializes player skills.
     *
     * @param array $skillData
     *
     * @return array
     *
     * @throws Exception
     */
    public static function createSkills(?array $skillData = null): array
    {
        if (is_array($skillData) === false) {
            return [];
        }

        $data = [];

        foreach ($skillData as $skillName => $skillMeta) {
            $skill = self::createSkill($skillName);
            $label = self::createLabel($skillName);

            $role   = $skillMeta["role"];
            $chance = $skillMeta["chance"];

            $skill->setRole($role);
            $skill->setChance($chance);
            $skill->setLabel($label);

            $data[$role]   = $data[$role] ?? [];
            $data[$role][] = $skill;
        }

        return $data;
    }

    /**
     * @param string $skill
     *
     * @return Skill
     *
     * @throws Exception
     */
    public static function createSkill(string $skill): Skill
    {
        $skillClass = self::getSkillClass($skill);

        return new $skillClass($skill);
    }

    /**
     * Retrieves the class that must be loaded for a specific skill.
     * Skill name is composed of words separated by "_".
     * The corresponding skill class name is built according to the skill name as follows:
     *
     * 1. split the skill name in multiple parts by the "_" character
     * 2. capitalize each word returned above
     * 3. join all words returned above
     *
     * e.g:
     *
     * skill: rapid_fire => className: RapidFire
     *
     * @param string $skill
     *
     * @return string
     *
     * @throws Exception
     */
    private static function getSkillClass(string $skill): string
    {
        $skillParts = explode("_", $skill);

        $skillParts = array_map(function ($word) {
            return ucfirst($word);
        }, $skillParts);

        $skillClass = implode("", $skillParts);

        $classFilePath = AutoloaderUtils::buildClassFilePath(self::CLASS_ROOT_PATH . "/{$skillClass}");

        if (file_exists($classFilePath) === false) {
            throw new \Exception("Fail to load class file [{$classFilePath}] for skill [$skill].");
        }

        $fullClassName = AutoloaderUtils::buildNamespaceFromParts([self::CLASS_ROOT_PATH, $skillClass]);

        require_once $classFilePath;

        $classLoaded = class_exists($fullClassName);

        if ($classLoaded === true) {
            return $fullClassName;
        }

        throw new \Exception("Fail to load class for skill: [$skill].");
    }

    /**
     * @param string $skillName
     *
     * @return string
     */
    private static function createLabel(string $skillName): string
    {
        return \strtoupper(\implode(" ", explode("_", $skillName)));
    }
}
