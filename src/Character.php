<?php

namespace CombatRPG;

class Character
{
    private int $health;
    private int $level;

    public function __construct()
    {
        $this->health = 1000;
        $this->level = 1;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function receivesDamage(int $damage): void
    {
        $this->health = max(0, $this->health - $damage);
    }

    public function isDead(): bool
    {
        return 0 === $this->health;
    }

    public function receivesHealing(int $healing): void
    {
        if ($this->isDead()) {
            return;
        }

        $this->health = min(1000, $this->health + $healing);
    }

    public function dealsDamage(Character $enemy, int $damage): void
    {
        if ($this === $enemy) {
            return;
        }

        $levelDifference = $this->level - $enemy->getLevel();

        $definitiveDamage = match (true) {
            $levelDifference <= -5 => (int) ($damage * 0.5),
            $levelDifference >= 5 => (int) ($damage * 1.5),
            default => $damage
        };

        $enemy->receivesDamage($definitiveDamage);
    }

    public function raiseLevel(int $levels): void
    {
        $this->level += $levels;
    }

    public function heals(Character $character, int $healing): void
    {
        if ($this !== $character) {
            return;
        }

        $character->receivesHealing($healing);
    }
}
