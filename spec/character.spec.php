<?php

use CombatRPG\Character;

const INITIAL_HEALTH = 1000;

describe('A Character', function () {
    context('initially', function () {
        it('starts with 1000 points of health', function () {
            $character = new Character();

            expect($character->getHealth())->toBe(INITIAL_HEALTH);
        });

        it('starts at level 1', function () {
            $character = new Character();

            expect($character->getLevel())->toBe(1);
        });

        it('is alive', function () {
            $character = new Character();

            expect($character->isDead())->toBe(false);
        });
    });

    context('when receives damage', function () {
        context('if the damage is lethal (is over his/her current health)', function () {
            it('dies', function () {
                $character = new Character();
                $lethalDamage = INITIAL_HEALTH + 200;

                $character->receivesDamage($lethalDamage);

                expect($character->isDead())->toBe(true);
            });

            it('gets 0 health', function () {
                $character = new Character();
                $lethalDamage = INITIAL_HEALTH + 200;

                $character->receivesDamage($lethalDamage);

                expect($character->getHealth())->toBe(0);
            });
        });

        context('if the damage is not lethal', function () {
            it('remains alive', function () {
                $character = new Character();
                $damage = 400;

                $character->receivesDamage($damage);

                expect($character->isDead())->toBe(false);
            });

            it('reduces his/her health', function () {
                $character = new Character();
                $damage = 400;

                $character->receivesDamage($damage);

                expect($character->getHealth())->toBe(INITIAL_HEALTH - $damage);
            });
        });
    });

    context('that is dead', function () {
        it('cannot be healed', function () {
            $character = new Character();
            $lethalDamage = 1000;
            $healing = 200;

            $character->receivesDamage($lethalDamage);

            $character->heals($healing);

            expect($character->getHealth())->toBe(0);
            expect($character->isDead())->toBe(true);
        });
    });

    context('that is alive', function () {
        context('when is healed', function () {
            it('increases his/her health points', function () {
                $character = new Character();
                $damage = 400;
                $healing = 200;

                $character->receivesDamage($damage);

                $character->heals($healing);

                expect($character->getHealth())->toBe(INITIAL_HEALTH - $damage + $healing);
            });
            context('if will get fully healed', function () {
                it('remains with 1000 points of health', function () {
                    $character = new Character();
                    $damage = 200;
                    $healing = 400;

                    $character->receivesDamage($damage);

                    $character->heals($healing);

                    expect($character->getHealth())->toBe(INITIAL_HEALTH);
                });
            });
        });
    });
});
