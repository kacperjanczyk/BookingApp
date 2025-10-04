<?php

namespace App\Dto;

use App\Query\FindAvailableVacanciesQuery;

final readonly class GetVacanciesRequestDto
{
    public function __construct(
        public ?int $startDate = null,
        public ?int $endDate = null
    ) {
    }

    public static function fromRequest(array $query): self
    {
        return new self(
            startDate: isset($query['startDate']) ? (int)$query['startDate'] : null,
            endDate: isset($query['endDate']) ? (int)$query['endDate'] : null
        );
    }

    public function toQuery(): FindAvailableVacanciesQuery
    {
        return new FindAvailableVacanciesQuery($this->startDate, $this->endDate);
    }
}
