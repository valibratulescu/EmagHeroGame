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
  chance he’ll use this skill every time he defends.

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

## Prerequisites (for Windows)

- Install PHP
- Install Git Bash and Git CLI
- Install MySQL server
- Install Composer

## Requirements

- PHP >=8.2
- Symfony 7.0

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
1. Welcome to the forest of Emagia!
================================

Orderus has been summoned. He's ready to protect Emagia with his skills
{
    "health": 74,
    "strength": 70,
    "defence": 49,
    "speed": 47,
    "luck": 11
}
Pick the monster that wants to conquer Emagia: Troll
Troll has been summoned. He's ready to fight our hero
{
    "health": 77,
    "strength": 67,
    "defence": 53,
    "speed": 49,
    "luck": 38
}
Players are ready to fight. The battle shall begin.
Troll will strike now
Let's see if Orderus can resist


Troll strikes for 18 damage
Orderus's remaining health is 56
Orderus will strike now
Let's see if Troll can resist


Orderus strikes for 17 damage
Troll's remaining health is 60
Troll will strike now
Let's see if Orderus can resist


[Magic Shield] skill activated for Orderus
Troll strikes for 9 damage
Orderus's remaining health is 47
Orderus will strike now
Let's see if Troll can resist


Orderus strikes for 17 damage
Troll's remaining health is 43
Troll will strike now
Let's see if Orderus can resist


Troll strikes for 18 damage
Orderus's remaining health is 29
Orderus will strike now
Let's see if Troll can resist


Orderus strikes for 17 damage
Troll's remaining health is 26
Troll will strike now
Let's see if Orderus can resist


Orderus manages to dodge the attack from Troll
Orderus will strike now
Let's see if Troll can resist


Orderus strikes for 17 damage
Troll's remaining health is 9
Troll will strike now
Let's see if Orderus can resist


Troll strikes for 18 damage
Orderus's remaining health is 11
Orderus will strike now
Let's see if Troll can resist


Orderus strikes for 17 damage
Troll's remaining health is 0
Troll has been defeated.


2. Welcome to the forest of Emagia!
================================

Orderus has been summoned. He's ready to protect Emagia with his skills
{
    "health": 83,
    "strength": 70,
    "defence": 50,
    "speed": 50,
    "luck": 11
}
Pick the monster that wants to conquer Emagia: Mirana
Mirana has been summoned. He's ready to fight our hero
{
    "health": 87,
    "strength": 61,
    "defence": 53,
    "speed": 55,
    "luck": 38
}
Players are ready to fight. The battle shall begin.
Mirana will strike now
Let's see if Orderus can resist


Mirana strikes for 11 damage
Orderus's remaining health is 72
Orderus will strike now
Let's see if Mirana can resist


Mirana manages to dodge the attack from Orderus
Mirana will strike now
Let's see if Orderus can resist


Mirana strikes for 11 damage
Orderus's remaining health is 61
Orderus will strike now
Let's see if Mirana can resist


Orderus strikes for 17 damage
Mirana's remaining health is 70
Mirana will strike now
Let's see if Orderus can resist


Mirana strikes for 11 damage
Orderus's remaining health is 50
Orderus will strike now
Let's see if Mirana can resist


Orderus strikes for 17 damage
Mirana's remaining health is 53
Mirana will strike now
Let's see if Orderus can resist


Mirana strikes for 11 damage
Orderus's remaining health is 39
Orderus will strike now
Let's see if Mirana can resist


[Rapid Strike] skill activated for Orderus
Orderus strikes for 34 damage
Mirana's remaining health is 19
Mirana will strike now
Let's see if Orderus can resist


Mirana strikes for 11 damage
Orderus's remaining health is 28
Orderus will strike now
Let's see if Mirana can resist


Orderus strikes for 17 damage
Mirana's remaining health is 2
Mirana will strike now
Let's see if Orderus can resist


Mirana strikes for 11 damage
Orderus's remaining health is 17
Orderus will strike now
Let's see if Mirana can resist


Orderus strikes for 17 damage
Mirana's remaining health is 0
Mirana has been defeated.

3. Welcome to the forest of Emagia!
================================

Orderus has been summoned. He's ready to protect Emagia with his skills
{
    "health": 96,
    "strength": 79,
    "defence": 48,
    "speed": 50,
    "luck": 10
}
Pick the monster that wants to conquer Emagia: Shadow Hunter
Shadow Hunter has been summoned. He's ready to fight our hero
{
    "health": 69,
    "strength": 90,
    "defence": 60,
    "speed": 46,
    "luck": 31
}
Players are ready to fight. The battle shall begin.
Shadow Hunter will strike now
Let's see if Orderus can resist
Successfully acquired the "{resource}" lock.


[Magic Shield] skill activated for Orderus
Shadow Hunter strikes for 21 damage
Orderus's remaining health is 75
Orderus will strike now
Let's see if Shadow Hunter can resist
Successfully acquired the "{resource}" lock.


Orderus strikes for 19 damage
Shadow Hunter's remaining health is 50
Shadow Hunter will strike now
Let's see if Orderus can resist
Successfully acquired the "{resource}" lock.


Shadow Hunter strikes for 42 damage
Orderus's remaining health is 33
Orderus will strike now
Let's see if Shadow Hunter can resist
Successfully acquired the "{resource}" lock.


[Rapid Strike] skill activated for Orderus
Orderus strikes for 38 damage
Shadow Hunter's remaining health is 12
Shadow Hunter will strike now
Let's see if Orderus can resist
Successfully acquired the "{resource}" lock.


[Magic Shield] skill activated for Orderus
Shadow Hunter strikes for 21 damage
Orderus's remaining health is 12
Orderus will strike now
Let's see if Shadow Hunter can resist
Successfully acquired the "{resource}" lock.


Shadow Hunter manages to dodge the attack from Orderus
Shadow Hunter will strike now
Let's see if Orderus can resist
Successfully acquired the "{resource}" lock.


Shadow Hunter strikes for 42 damage
Orderus's remaining health is 0
Orderus has been defeated.

```