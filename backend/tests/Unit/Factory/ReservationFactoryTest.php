<?php

namespace App\Tests\Unit\Factory;

use App\Dto\CreateReservationDto;
use App\Entity\Reservation;
use App\Factory\ReservationFactory;
use App\Tests\Fixtures\ReservationFixtures;
use PHPUnit\Framework\TestCase;

class ReservationFactoryTest extends TestCase
{
    private ReservationFactory $factory;

    protected function setUp(): void
    {
        $this->factory = new ReservationFactory();
    }

    public function testCreateFromDto(): void
    {
        $dto = ReservationFixtures::createDefaultDto();

        $reservation = $this->factory->createFromDto($dto);

        $this->assertReservationMatchesDto($reservation, $dto);
    }

    private function assertReservationMatchesDto(Reservation $reservation, CreateReservationDto $dto): void
    {
        $this->assertEquals(
            $dto->getStartDateTime()->getTimestamp(),
            $reservation->getStartDate()->getTimestamp()
        );
        $this->assertEquals(
            $dto->getEndDateTime()->getTimestamp(),
            $reservation->getEndDate()->getTimestamp()
        );
        $this->assertEquals($dto->name, $reservation->getName());
        $this->assertEquals($dto->surname, $reservation->getSurname());
        $this->assertEquals($dto->email, $reservation->getEmail());
        $this->assertEquals($dto->phoneNumber, $reservation->getPhone());
        $this->assertEquals(Reservation::STATUS_PENDING, $reservation->getStatus());
    }
}
