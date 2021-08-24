<?php

namespace Tests\Emagia\Hero\Skills;

use Emagia\Hero\Factory\SkillFactory;
use Emagia\Hero\Handlers\Skill;
use PHPUnit\Framework\TestCase;

class SkillTest extends TestCase
{
    /**
     * @var Skill
     */
    protected $skill;

    protected function setUp()
    {
        $this->skill = SkillFactory::createSkill("rapid_strike");
    }

    public function testName()
    {
        self::assertNotEmpty($this->skill->getName(), "Name not set for skill");
    }

    public function testChance()
    {
        $this->skill->setChance(15);

        self::assertEquals(15, $this->skill->getChance(), "Chance not set for skill");
    }

    public function testRole()
    {
        $this->skill->setRole("attack");

        self::assertEquals("attack", $this->skill->getRole(), "Role not set for skill");
    }
}
