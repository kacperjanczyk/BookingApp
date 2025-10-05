<?php

namespace App\Tests\Fixtures;

use App\Entity\Vacancy;

class VacancyMother
{
    public static function createWithAvailableCount(int $count): Vacancy
    {
        $vacancy = new Vacancy();
        $vacancy->setAvailableCount($count);

        return $vacancy;
    }

    public static function createEmpty(): Vacancy
    {
        return self::createWithAvailableCount(0);
    }

    public static function createWithSpotsAvailable(): Vacancy
    {
        return self::createWithAvailableCount(5);
    }

    public static function createForDate(
        int $timestamp,
        float $price = 100.0,
        int $totalCount = 10,
        int $availableCount = 5
    ): Vacancy {
        $vacancy = new Vacancy();
        $vacancy->setDate((new \DateTime())->setTimestamp($timestamp));
        $vacancy->setPrice($price);
        $vacancy->setTotalCount($totalCount);
        $vacancy->setAvailableCount($availableCount);

        return $vacancy;
    }

    public static function createFullyBoocked(int $timestamp): Vacancy
    {
        return self::createForDate($timestamp, 100.0, 10, 0);
    }

    public static function createAvailable(int $timestamp): Vacancy
    {
        return self::createForDate($timestamp, 100.0, 10, 5);
    }
}
