<?php

namespace App\Factory;

use App\Dto\CreateReservationDto;
use App\Entity\Reservation;

final class ReservationFactory
{
    public function createFromDto(CreateReservationDto $dto): Reservation
    {
        $reservation = new Reservation();
        $reservation
            ->setStartDate((new \DateTime())->setTimestamp($dto->startDate))
            ->setEndDate((new \DateTime())->setTimestamp($dto->endDate))
            ->setStatus(Reservation::STATUS_PENDING)
            ->setName($dto->name)
            ->setSurname($dto->surname)
            ->setEmail($dto->email)
            ->setPhone($dto->phoneNumber);

        return $reservation;
    }
}
