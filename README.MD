# EmagHeroGame

##### Author: Valentin Bratulescu

## The story

Once upon a time there was a great hero, called Orderus, with some strengths and weaknesses, as all heroes have.
After battling all kinds of monsters for more than a hundred years, Orderus now has the following stats:

- Health: 70 - 100
- Strength: 70 - 80
- Defence: 45 – 55
- Speed: 40 – 50
- Luck: 10% - 30% (0% means no luck, 100% lucky all the time).

Also, he possesses 2 skills:

- Rapid strike: Strike twice while it’s his turn to attack; there’s a 10% chance he’ll use this skill
every time he attacks
- Magic shield: Takes only half of the usual damage when an enemy attacks; there’s a 20%
change he’ll use this skill every time he defends.

## Gameplay

As Orderus walks the ever-green forests of Emagia, he encounters some wild beasts, with the following properties:

- Health: 60 - 90
- Strength: 60 - 90
- Defence: 40 – 60
- Speed: 40 – 60
- Luck: 25% - 40%

Simulate a battle between Orderus and a wild beast.
The first attack is done by the player with the higher speed. If both players have the same speed, than the attack is carried on by the player with the highest luck. After an attack, the players switch roles: the attacker now defends and the defender now attacks.

The damage done by the attacker is calculated with the following formula:

<b>Damage = Attacker strength – Defender defence</b>

The damage is subtracted from the defender’s health. An attacker can miss their hit and do no damage if the defender gets lucky that turn. Orderus’ skills occur randomly, based on their chances, so take them into account on each turn

## Game over

The game ends when one of the players remain without health or the number of turns reaches 20.
The application must output the results each turn: what happened, which skills were used (if any), the damage done, defender’s health left.
If we have a winner before the maximum number of rounds is reached, he must be declared.

## Requirements

- PHP 7.4
- Symfony 5.3.6

## Setup

```bat
$ composer install
$ symfony check:requirements
```

## Usage

```bat
$ php bin/console app:hero-game
```

## Output example

#### Example 1

```pre
Welcome to the holy ground
Let the fight begin
============
Preparing players...
Please enter the hero name: ORDERUS
Please enter the beast name: LUNA
Players are ready
The battle is going to be between ORDERUS and LUNA
============
Initializing players...
Done initializing players.

Presenting players...

======LUNA======

health => 67
strength => 90
defence => 53
speed => 52
luck => 31

======ORDERUS======

health => 72
strength => 72
defence => 48
speed => 40
luck => 22

Done presenting players.
Players are warming up...
==========
LUNA is ready to strike!
LUNA strength is 90
ORDERUS defence is 72
LUNA hits the target and deals 37 damage
ORDERUS has 35 HP left
==========
ORDERUS is ready to strike!
ORDERUS strength is 72
LUNA defence is 90
ORDERUS hits the target and deals 24 damage
LUNA has 43 HP left
==========
LUNA is ready to strike!
LUNA strength is 90
ORDERUS defence is 72
LUNA misses the target. ORDERUS got lucky this time
ORDERUS has 35 HP left
==========
ORDERUS is ready to strike!
ORDERUS strength is 72
LUNA defence is 90
Skill RAPID STRIKE activated for ORDERUS
ORDERUS hits the target and deals 43 damage
ORDERUS won. LUNA has been defeated!
```