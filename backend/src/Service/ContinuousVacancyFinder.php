<?php

namespace App\Service;

use App\Repository\VacancyRepository;

final readonly class ContinuousVacancyFinder
{
    public function __construct(
        private VacancyRepository $vacancyRepository
    ) {
    }

    public function findContinuousVacancies(array $requiredDates): array
    {
        if (empty($requiredDates)) {
            return new \InvalidArgumentException('Date range cannot be empty.');
        }

        $vacancies = [];
        foreach ($requiredDates as $date) {
            $vacancy = $this->vacancyRepository->findOneAvailableForDate($date);

            if ($vacancy === null) {
                throw new \RuntimeException(
                    sprintf(
                        'No available vacancy found for date %s.',
                        $date->format('Y-m-d')
                    )
                );
            }

            $vacancies[] = $vacancy;
        }

        return $vacancies;
    }
}
