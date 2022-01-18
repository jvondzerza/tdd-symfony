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

        $this->assertEquals($expectedOutput, $room->canBookPremium($user));
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

    public function dataProviderForBookingConflicts() : array
    {
        $date1 = new \DateTime('2011-01-01T15:03:01.012345Z');
        $date2 = new \DateTime('2012-09-26');
        $date3 = new \DateTime('2012-09-26');

        return [
            [new Bookings($date1), $date1, true],
            [new Bookings($date1), $date2, false],
            [new Bookings($date2), $date3, true]
        ];
    }

    /**
     * function has to start with Test
     * @dataProvider dataProviderForBookingConflicts
     */
    public function testBookingConflicts (Bookings $booking, \DateTime $startDate, bool $expectedOutcome): void
    {
        $room = new Room(false);
        $this->assertEquals($expectedOutcome, $room->isBooked($booking, $startDate));

    }
}
