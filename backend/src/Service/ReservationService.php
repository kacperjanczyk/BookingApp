<?php

namespace App\Service;

use App\Dto\CreateReservationDto;
use App\Entity\Reservation;
use App\Factory\ReservationFactory;
use Doctrine\ORM\EntityManagerInterface;

final readonly class ReservationService
{
    public function __construct(
        private VacancyAvailabilityService  $vacancyAvailabilityService,
        private ContinuousVacancyFinder     $continuousVacancyFinder,
        private ReservationVacancyService   $reservationVacancyService,
        private ReservationFactory          $reservationFactory,
        private EntityManagerInterface      $entityManager
    ) {
    }

    public function createReservation(CreateReservationDto $dto): Reservation
    {
        $requiredDates = $dto->getDateRange();
        $vacancies = $this->continuousVacancyFinder->findContinuousVacancies($requiredDates);
        $reservation = $this->reservationFactory->createFromDto($dto);

        $totalPrice = 0.0;
        foreach ($vacancies as $vacancy) {
            $this->vacancyAvailabilityService->decreaseAvailability($vacancy);
            $this->reservationVacancyService->addVacancyToReservation(
                $reservation,
                $vacancy
            );

            $totalPrice += $vacancy->getPrice();
        }

        $reservation->setPrice($totalPrice);

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        return $reservation;
    }

    public function confirmReservation(Reservation $reservation): void
    {
        if ($reservation->getStatus() === Reservation::STATUS_CONFIRMED) {
            throw new \LogicException('Reservation is already confirmed.');
        }

        if ($reservation->getStatus() === Reservation::STATUS_CANCELLED) {
            throw new \LogicException('Cannot confirm a cancelled reservation.');
        }

        $reservation->setStatus(Reservation::STATUS_CONFIRMED);
        $this->entityManager->persist($reservation);
        $this->entityManager->flush();
    }

    public function cancelReservation(Reservation $reservation): void
    {
        $reservation->setStatus(Reservation::STATUS_CANCELLED);

        foreach ($reservation->getReservationVacancies() as $reservationVacancy) {
            $vacancy = $reservationVacancy->getVacancy();
            $this->vacancyAvailabilityService->increaseAvailability($vacancy);
            $this->reservationVacancyService->removeVacancyFromReservation($reservationVacancy);
        }

        $this->entityManager->persist($reservation);
        $this->entityManager->flush();
    }
}
