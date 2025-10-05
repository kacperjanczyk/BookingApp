<?php

namespace App\Tests\Fixtures;

use App\Dto\CreateReservationDto;

class ReservationFixtures
{
    public const DEFAULT_START_TIMESTAMP = 1735686000; // 2025-01-01 00:00:00
    public const DEFAULT_END_TIMESTAMP = 1735858800;   // 2025-01-03 00:00:00
    public const DEFAULT_NAME = 'John';
    public const DEFAULT_SURNAME = 'Doe';
    public const DEFAULT_EMAIL = 'john@example.com';
    public const DEFAULT_PHONE_NUMBER = '+48123456789';

    public static function createDefaultDto(): CreateReservationDto
    {
        return new CreateReservationDto(
            startDate: self::DEFAULT_START_TIMESTAMP,
            endDate: self::DEFAULT_END_TIMESTAMP,
            name: self::DEFAULT_NAME,
            surname: self::DEFAULT_SURNAME,
            email: self::DEFAULT_EMAIL,
            phoneNumber: self::DEFAULT_PHONE_NUMBER
        );
    }

    public static function createDtoWithDates(int $startDate, int $endDate): CreateReservationDto
    {
        return new CreateReservationDto(
            startDate: $startDate,
            endDate: $endDate,
            name: self::DEFAULT_NAME,
            surname: self::DEFAULT_SURNAME,
            email: self::DEFAULT_EMAIL,
            phoneNumber: self::DEFAULT_PHONE_NUMBER
        );
    }

    public static function defaultRequestData(): array
    {
        return [
            'startDate' => self::DEFAULT_START_TIMESTAMP,
            'endDate' => self::DEFAULT_END_TIMESTAMP,
            'name' => self::DEFAULT_NAME,
            'surname' => self::DEFAULT_SURNAME,
            'email' => self::DEFAULT_EMAIL,
            'phoneNumber' => self::DEFAULT_PHONE_NUMBER,
        ];
    }
}
