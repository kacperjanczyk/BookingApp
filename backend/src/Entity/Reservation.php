<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    const STATUS_PENDING = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_CANCELLED = 2;

    const STATUS_LABELS = [
        self::STATUS_PENDING => 'Pending',
        self::STATUS_CONFIRMED => 'Confirmed',
        self::STATUS_CANCELLED => 'Cancelled',
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $endDate = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(type: Types::SMALLINT, options: ['default' => self::STATUS_PENDING])]
    private ?int $status = null;

    /**
     * @var Collection<int, ReservationVacancy>
     */
    #[ORM\OneToMany(targetEntity: ReservationVacancy::class, mappedBy: 'reservation', orphanRemoval: true)]
    private Collection $reservationVacancies;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $surname = null;

    #[ORM\Column(length: 100)]
    private ?string $email = null;

    #[ORM\Column(length: 15)]
    private ?string $phone = null;

    public function __construct()
    {
        $this->reservationVacancies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTime
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTime $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection<int, ReservationVacancy>
     */
    public function getReservationVacancies(): Collection
    {
        return $this->reservationVacancies;
    }

    public function addReservationVacancy(ReservationVacancy $reservationVacancy): static
    {
        if (!$this->reservationVacancies->contains($reservationVacancy)) {
            $this->reservationVacancies->add($reservationVacancy);
            $reservationVacancy->setReservation($this);
        }

        return $this;
    }

    public function removeReservationVacancy(ReservationVacancy $reservationVacancy): static
    {
        if ($this->reservationVacancies->removeElement($reservationVacancy)) {
            // set the owning side to null (unless already changed)
            if ($reservationVacancy->getReservation() === $this) {
                $reservationVacancy->setReservation(null);
            }
        }

        return $this;
    }
}
