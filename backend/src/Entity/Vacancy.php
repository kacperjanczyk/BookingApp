<?php

namespace App\Entity;

use App\Repository\VacancyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: VacancyRepository::class)]
#[ORM\Table(name: 'vacancies')]
#[ORM\Index(name: 'idx_vacancy_date', columns: ['date'])]
class Vacancy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?int $totalCount = null;

    #[ORM\Column]
    private ?int $availableCount = null;

    /**
     * @var Collection<int, ReservationVacancy>
     */
    #[ORM\OneToMany(targetEntity: ReservationVacancy::class, mappedBy: 'Vacancy', orphanRemoval: true)]
    #[Ignore]
    private Collection $reservationVacancies;

    public function __construct()
    {
        $this->reservationVacancies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

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

    public function getTotalCount(): ?int
    {
        return $this->totalCount;
    }

    public function setTotalCount(int $totalCount): static
    {
        $this->totalCount = $totalCount;

        return $this;
    }

    public function getAvailableCount(): ?int
    {
        return $this->availableCount;
    }

    public function setAvailableCount(int $availableCount): static
    {
        $this->availableCount = $availableCount;

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
            $reservationVacancy->setVacancy($this);
        }

        return $this;
    }

    public function removeReservationVacancy(ReservationVacancy $reservationVacancy): static
    {
        if ($this->reservationVacancies->removeElement($reservationVacancy)) {
            // set the owning side to null (unless already changed)
            if ($reservationVacancy->getVacancy() === $this) {
                $reservationVacancy->setVacancy(null);
            }
        }

        return $this;
    }
}
