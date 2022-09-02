<?php

namespace CombatRPG;

class Character
{
    private int $health;

    public function __construct()
    {
        $this->health = 1000;
    }

    public function getHealth(): int
    {
        return $this->health;
    }

    public function getLevel(): int
    {
        return 1;
    }

    public function receivesDamage(int $damage)
    {
        $this->health = max(0, $this->health - $damage);
    }

    public function isDead(): bool
    {
        return 0 === $this->health;
    }

    public function heals(int $healing)
    {
        if ($this->isDead()) {
            return;
        }

        $this->health = min(1000, $this->health + $healing);
    }
}
