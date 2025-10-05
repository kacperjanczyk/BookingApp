<?php

namespace App\Tests\Fixtures;

use App\Entity\Reservation;

class ReservationMother
{
    public static function createPending(
        int $startTimestamp,
        int $endTimestamp,
        float $price = 300.0
    ): Reservation {
        $reservation = new Reservation();
        $reservation->setStartDate((new \DateTime())->setTimestamp($startTimestamp));
        $reservation->setEndDate((new \DateTime())->setTimestamp($endTimestamp));
        $reservation->setName(ReservationFixtures::DEFAULT_NAME);
        $reservation->setSurname(ReservationFixtures::DEFAULT_SURNAME);
        $reservation->setEmail(ReservationFixtures::DEFAULT_EMAIL);
        $reservation->setPhone(ReservationFixtures::DEFAULT_PHONE_NUMBER);
        $reservation->setPrice($price);
        $reservation->setStatus(Reservation::STATUS_PENDING);

        return $reservation;
    }

    public static function createDefaultPending(): Reservation
    {
        return self::createPending(
            ReservationFixtures::DEFAULT_START_TIMESTAMP,
            ReservationFixtures::DEFAULT_END_TIMESTAMP
        );
    }
}
