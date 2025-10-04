<?php

namespace App\Query;

final readonly class FindAvailableVacanciesQuery
{
    public function __construct(
        private ?int $startDate = null,
        private ?int $endDate = null
    ) {
    }

    public function getStartDate(): ?int
    {
        return $this->startDate;
    }

    public function getEndDate(): ?int
    {
        return $this->endDate;
    }

    public function getStartDateTime(): ?\DateTime
    {
        return $this->startDate
            ? (new \DateTime())->setTimestamp($this->startDate)->setTime(0, 0, 0)
            : null;
    }

    public function getEndDateTime(): ?\DateTime
    {
        return $this->endDate
            ? (new \DateTime())->setTimestamp($this->endDate)->setTime(23, 59, 59)
            : null;
    }
}
