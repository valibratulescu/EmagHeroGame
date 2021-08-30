<?php

namespace App\Entity\Constant;

class Player
{
    /**
     * @var array
     */
    const HERO = [
        "skills" => [
            "rapid_strike" => [
                "role"   => "attack",
                "chance" => 10,
            ],
            "magic_shield" => [
                "role"   => "defence",
                "chance" => 20,
            ],
        ],
        "stats"  => [
            "health"   => [
                "min" => 70,
                "max" => 100,
            ],
            "strength" => [
                "min" => 70,
                "max" => 80,
            ],
            "defence"  => [
                "min" => 45,
                "max" => 55,
            ],
            "speed"    => [
                "min" => 40,
                "max" => 50,
            ],
            "luck"     => [
                "min" => 10,
                "max" => 30,
            ],
        ],
    ];

    /**
     * @var array
     */
    const BEAST = [
        "stats" => [
            "health"   => [
                "min" => 60,
                "max" => 90,
            ],
            "strength" => [
                "min" => 60,
                "max" => 90,
            ],
            "defence"  => [
                "min" => 40,
                "max" => 60,
            ],
            "speed"    => [
                "min" => 40,
                "max" => 60,
            ],
            "luck"     => [
                "min" => 25,
                "max" => 40,
            ],
        ],
    ];

    /**
     * @var string
     */
    const ROLE_ATTACKER = "attack";

    /**
     * @var string
     */
    const ROLE_DEFENDER = "defence";
}
