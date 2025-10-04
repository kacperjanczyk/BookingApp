<?php

namespace App\Entity;

use App\Repository\ReservationVacancyRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationVacancyRepository::class)]
class ReservationVacancy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservationVacancies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reservation $reservation = null;

    #[ORM\ManyToOne(inversedBy: 'reservationVacancies')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vacancy $Vacancy = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): static
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getVacancy(): ?Vacancy
    {
        return $this->Vacancy;
    }

    public function setVacancy(?Vacancy $Vacancy): static
    {
        $this->Vacancy = $Vacancy;

        return $this;
    }
}
