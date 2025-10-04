<?php

namespace App\Dto;

use App\Entity\Reservation;

final readonly class ReservationResponseDto
{
    public function __construct(
        public int $id,
        public int $startDate,
        public int $endDate,
        public string $status,
        public string $name,
        public string $surname,
        public string $email,
        public string $phone,
        public float $price
    ) {
    }

    public static function fromEntity(Reservation $reservation): self
    {
        return new self(
            id: $reservation->getId(),
            startDate: $reservation->getStartDate()->getTimestamp(),
            endDate: $reservation->getEndDate()->getTimestamp(),
            status: $reservation->getStatus(),
            name: $reservation->getName(),
            surname: $reservation->getSurname(),
            email: $reservation->getEmail(),
            phone: $reservation->getPhone(),
            price: $reservation->getPrice()
        );
    }
}
