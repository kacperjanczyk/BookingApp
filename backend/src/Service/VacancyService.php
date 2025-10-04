<?php

namespace App\Service;

use App\Dto\GetVacanciesRequestDto;
use App\Entity\Vacancy;
use App\Repository\ReservationVacancyRepository;
use App\Repository\VacancyRepository;
use Doctrine\ORM\EntityManagerInterface;

final readonly class VacancyService
{
    public function __construct(
        private VacancyRepository               $vacancyRepository,
        private ReservationVacancyRepository    $reservationVacancyRepository,
        private EntityManagerInterface          $entityManager
    ) {
    }

    public function getAvailableVacancies(GetVacanciesRequestDto $dto): array
    {
        $query = $dto->toQuery();
        return $this->vacancyRepository->findByQuery($query);
    }

    public function createVacancy(Vacancy $vacancy): void
    {
        if ($vacancy->getAvailableCount() === null) {
            $vacancy->setAvailableCount($vacancy->getTotalCount());
        }

        if ($vacancy->getAvailableCount() > $vacancy->getTotalCount()) {
            throw new \InvalidArgumentException('Available count cannot be greater than total count.');
        }

        $this->entityManager->persist($vacancy);
        $this->entityManager->flush();
    }

    public function updateVacancy(Vacancy $vacancy): void
    {
        if ($vacancy->getAvailableCount() > $vacancy->getTotalCount()) {
            throw new \InvalidArgumentException('Available count cannot be greater than total count.');
        }

        $this->entityManager->flush();
    }

    public function deleteVacancy(Vacancy $vacancy): void
    {
        $reservationVacancies = $this->reservationVacancyRepository->findBy([
            'Vacancy' => $vacancy->getId()
        ]);

        if (count($reservationVacancies) > 0) {
            throw new \RuntimeException('Cannot delete vacancy with existing reservations.');
        }

        $this->entityManager->remove($vacancy);
        $this->entityManager->flush();
    }
}
