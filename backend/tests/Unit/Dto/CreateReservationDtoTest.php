<?php

namespace App\Tests\Unit\Dto;

use App\Dto\CreateReservationDto;
use App\Tests\Fixtures\ReservationFixtures;
use PHPUnit\Framework\TestCase;

class CreateReservationDtoTest extends TestCase
{
    public function testFromRequest(): void
    {
        $data = ReservationFixtures::defaultRequestData();

        $dto = CreateReservationDto::fromRequest($data);

        $this->assertEquals(ReservationFixtures::DEFAULT_START_TIMESTAMP, $dto->startDate);
        $this->assertEquals(ReservationFixtures::DEFAULT_END_TIMESTAMP, $dto->endDate);
        $this->assertEquals(ReservationFixtures::DEFAULT_NAME, $dto->name);
        $this->assertEquals(ReservationFixtures::DEFAULT_SURNAME, $dto->surname);
        $this->assertEquals(ReservationFixtures::DEFAULT_EMAIL, $dto->email);
        $this->assertEquals(ReservationFixtures::DEFAULT_PHONE_NUMBER, $dto->phoneNumber);
    }

    public function testGetStartDateTime(): void
    {
        $dto = ReservationFixtures::createDefaultDto();
        $startDateTime = $dto->getStartDateTime();

        $this->assertEquals(ReservationFixtures::DEFAULT_START_TIMESTAMP, $startDateTime->getTimestamp());
    }

    public function testGetEndDateTime(): void
    {
        $dto = ReservationFixtures::createDefaultDto();
        $endDateTime = $dto->getEndDateTime();

        $this->assertEquals(ReservationFixtures::DEFAULT_END_TIMESTAMP, $endDateTime->getTimestamp());
    }

    /**
     * @dataProvider dateRangeProvider
     */
    public function testGetDateRange(int $startDate, int $endDate, int $expectedCount, array $expectedDates): void
    {
        $dto = ReservationFixtures::createDtoWithDates($startDate, $endDate);
        $dateRange = $dto->getDateRange();

        $this->assertCount($expectedCount, $dateRange);
        foreach ($expectedDates as $index => $expectedDate) {
            $this->assertEquals($expectedDate, $dateRange[$index]->getTimestamp());
        }
    }

    public static function dateRangeProvider(): array
    {
        return [
            'three days range' => [
                'startDate' => 1735686000, // 2025-01-01
                'endDate' => 1735858800,   // 2025-01-03
                'expectedCount' => 3,
                'expectedDates' => [1735686000, 1735772400, 1735858800],
            ],
            'single day' => [
                'startDate' => 1735686000, // 2025-01-01
                'endDate' => 1735686000,   // 2025-01-01
                'expectedCount' => 1,
                'expectedDates' => [1735686000],
            ],
            'two days range' => [
                'startDate' => 1735686000, // 2025-01-01
                'endDate' => 1735772400,   // 2025-01-02
                'expectedCount' => 2,
                'expectedDates' => [1735686000, 1735772400],
            ],
        ];
    }
}
