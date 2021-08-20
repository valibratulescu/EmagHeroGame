<?php

namespace Emagia\Hero\Metadata;

class PlayerMetadata
{
    const PLAYERS = [
        [
            "name"   => "ORDERUS",
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
        ],
        [
            "name"  => "BEAST",
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
        ],
    ];
}
