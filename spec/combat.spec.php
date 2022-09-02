<?php
/** @noinspection StaticClosureCanBeUsedInspection */

use CombatRPG\Character;

describe('During combat', function () {
    context('when a character deals damage', function () {
        context('to an enemy', function () {
            it('reduces the enemy\'s health points', function () {
                $character = new Character();
                $enemy = new Character();
                $damage = 400;

                $character->dealsDamage($enemy, $damage);

                expect($enemy->getHealth())->toBe(INITIAL_HEALTH - $damage);
            });

            context('if the enemy is 5 or more levels above him/her', function () {
                it('reduces the enemy\'s health by 50% of the damage points', function () {
                    $character = new Character();
                    $enemy = new Character();
                    $enemy->raiseLevel(5);
                    $damage = 400;

                    $character->dealsDamage($enemy, $damage);

                    $expectedRealDamage = (int)($damage * 0.5);
                    expect($enemy->getHealth())->toBe(INITIAL_HEALTH - $expectedRealDamage);
                });
            });

            context('if the enemy is 5 or more levels below him/her', function () {
                it('reduces the enemy\'s health by 150% of the damage points', function () {
                    $character = new Character();
                    $character->raiseLevel(5);
                    $enemy = new Character();
                    $damage = 400;

                    $character->dealsDamage($enemy, $damage);

                    $expectedRealDamage = (int)($damage * 1.5);
                    expect($enemy->getHealth())->toBe(INITIAL_HEALTH - $expectedRealDamage);
                });
            });
        });

        context('to himself', function () {
            it('does not receive any damage', function () {
                $character = new Character();
                $damage = 400;

                $character->dealsDamage($character, $damage);

                expect($character->getHealth())->toBe(INITIAL_HEALTH);
            });
        });
    });

    context('when a character heals', function () {
        context('an enemy', function () {
            it('does not increase enemy\'s health points', function () {
                $character = new Character();
                $enemy = new Character();
                $damage = 400;
                $healing = 200;

                $character->dealsDamage($enemy, $damage);
                $character->heals($enemy, $healing);

                expect($enemy->getHealth())->toBe(INITIAL_HEALTH - $damage);
            });
        });
        context('himself', function () {
            it('receives healing', function () {
                $character = new Character();
                $damage = 400;
                $healing = 200;

                $character->receivesDamage($damage);

                $character->heals($character, $healing);

                expect($character->getHealth())->toBe(INITIAL_HEALTH - $damage + $healing);
            });
        });
    });
});
