<?php

namespace App\Tests;

use App\Entity\Bookings;
use App\Entity\Room;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CheckRoomAvailabilityTest extends TestCase
{
    public function dataProviderForPremiumRoom() : array
    {
        return [
            [true, true, true],
            [false, false, true],
            [false, true, true],
            [true, false, false]
        ];
    }

    /**
     * function has to start with Test
     * @dataProvider dataProviderForPremiumRoom
     */
    public function testPremiumRoom(bool $roomVar, bool $userVar, bool $expectedOutput): void {

        $room = new Room($roomVar);
        $user = new User($userVar);

        $this->assertEquals($expectedOutput, $room->canBook($user));
    }

    public function dataProviderForBookingDuration() : array
    {
        return [
            [4, true],
            [5, false],
            [6, false],
            [3, true]
        ];
    }

    /**
     * function has to start with Test
     * @dataProvider dataProviderForBookingDuration
     */
    public function testBookingDuration (int $hours, bool $expectedOutput): void
    {
        $maxDuration = 4;
        $booking = new Bookings(new \DateTime());
        $start = $booking->getStartDate();
        $end = (clone $start)->add(new \DateInterval("PT{$hours}H"));
        $booking->setEndDate($end);
        $this->assertEquals($expectedOutput, $booking->canBeBooked($maxDuration));
    }
}
