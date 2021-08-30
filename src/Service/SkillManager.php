<?php

namespace App\Service;

use App\Entity\Constant\Skill as ConstantSkill;
use App\Entity\Skill;
use App\Service\Utils\MathUtils;
use Exception;

class SkillManager
{
    /**
     * @var MathUtils
     */
    private $mathUtils = null;

    public function __construct(MathUtils $mathUtils)
    {
        $this->mathUtils = $mathUtils;
    }

    /**
     * Initializes player skills.
     *
     * @param null|array $skillData
     *
     * @return array
     */
    public function createSkills(?array $skillData = null): array
    {
        if (is_array($skillData) === false) {
            return [];
        }

        $data = [];

        foreach ($skillData as $skillName => $skillMeta) {
            $skill = $this->createSkill($skillName);
            $label = $this->createLabel($skillName);

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
     * @param string $skillName
     *
     * @return Skill
     */
    private function createSkill(string $skillName)
    {
        return new Skill($skillName);
    }

    /**
     * @param Skill $skill
     *
     * @return bool
     */
    public function canActivate(Skill $skill): bool
    {
        return $this->mathUtils->checkWinChance($skill->getChance());
    }

    /**
     * @param Skill $skill
     * @param int $damage
     *
     * @return int
     *
     * @throws Exception
     */
    public function activate(Skill $skill, int $damage): int
    {
        $class = $this->getSkillClass($skill->getName());

        return (new $class())->activate($damage);
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
    private function getSkillClass(string $skill): string
    {
        $skillParts = explode("_", $skill);

        $skillParts = array_map(function ($word) {
            return ucfirst($word);
        }, $skillParts);

        $skillClass = implode("", $skillParts);

        $classFilePath = getcwd() . "/" . ConstantSkill::CLASS_ROOT_PATH . "/{$skillClass}.php";

        if (file_exists($classFilePath) === false) {
            throw new \Exception("Fail to load class file [{$classFilePath}] for skill [$skill].");
        }

        require_once $classFilePath;

        $fullClassName = ConstantSkill::CLASS_NAMESPACE_PATH . "\\{$skillClass}";

        $classLoaded = class_exists($fullClassName);

        if ($classLoaded === true) {
            return $fullClassName;
        }

        throw new \Exception("Fail to load class {$fullClassName} for skill: [$skill].");
    }

    /**
     * @param string $skillName
     *
     * @return string
     */
    private function createLabel(string $skillName): string
    {
        return \strtoupper(\implode(" ", explode("_", $skillName)));
    }
}
