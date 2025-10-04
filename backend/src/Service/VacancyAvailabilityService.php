<?php

namespace App\Service;

use App\Entity\Vacancy;
use Doctrine\ORM\EntityManagerInterface;

final readonly class VacancyAvailabilityService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function decreaseAvailability(Vacancy $vacancy): void
    {
        if ($vacancy->getAvailableCount() <= 0) {
            throw new \RuntimeException('No available vacancies left.');
        }

        $vacancy->setAvailableCount($vacancy->getAvailableCount() - 1);
        $this->entityManager->persist($vacancy);
    }

    public function increaseAvailability(Vacancy $vacancy): void
    {
        $vacancy->setAvailableCount($vacancy->getAvailableCount() + 1);
        $this->entityManager->persist($vacancy);
    }
}
