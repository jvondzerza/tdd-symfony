<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CheckCanAffordTest extends TestCase
{
    public function dataProviderForCanAfford() : array
    {
        return [
            [4, 20, true],
            [4, 6, false],
            [2, 1, false],
            [3, 8, true]
        ];
    }

    /**
     * function has to start with Test
     * @dataProvider dataProviderForCanAfford
     */
    public function testCanAfford(int $hours, int $credits, bool $expectedOutcome): void
    {
        $user = new User(false);
        $price = 2 * $hours;
        $user->setCredit($credits);
        $this->assertEquals($expectedOutcome, $user->canAfford($price));
    }
}
