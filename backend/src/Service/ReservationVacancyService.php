<?php

namespace App\Service;

use App\Entity\Reservation;
use App\Entity\ReservationVacancy;
use App\Entity\Vacancy;
use Doctrine\ORM\EntityManagerInterface;

final readonly class ReservationVacancyService
{
    public function __construct(
        private EntityManagerInterface $entityManager
    ) {
    }

    public function addVacancyToReservation(
        Reservation $reservation,
        Vacancy $vacancy
    ): ReservationVacancy {
        $reservationVacancy = new ReservationVacancy();
        $reservationVacancy
            ->setReservation($reservation)
            ->setVacancy($vacancy);

        $this->entityManager->persist($reservationVacancy);

        return $reservationVacancy;
    }

    public function removeVacancyFromReservation(
        ReservationVacancy $reservationVacancy
    ): void {
        $this->entityManager->remove($reservationVacancy);
    }
}
