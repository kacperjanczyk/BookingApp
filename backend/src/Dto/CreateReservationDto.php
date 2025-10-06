<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateReservationDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Start date is required.')]
        #[Assert\Type(type: 'integer')]
        #[Assert\Positive]
        public int $startDate,

        #[Assert\NotBlank(message: 'End date is required.')]
        #[Assert\Type(type: 'integer')]
        #[Assert\Positive]
        #[Assert\GreaterThanOrEqual(
            propertyPath: 'startDate',
            message: 'End date must be equal or grater than start date.'
        )]
        public int $endDate,

        #[Assert\NotBlank(message: 'Name is required.')]
        #[Assert\Type(type: 'string')]
        #[Assert\Length(
            min: 2,
            max: 100,
            minMessage: 'Name must be at least {{ limit }} characters long.',
            maxMessage: 'Name cannot be longer than {{ limit }} characters.'
        )]
        public string $name,

        #[Assert\NotBlank(message: 'Surname is required.')]
        #[Assert\Type(type: 'string')]
        #[Assert\Length(
            min: 2,
            max: 100,
            minMessage: 'Surname must be at least {{ limit }} characters long.',
            maxMessage: 'Surname cannot be longer than {{ limit }} characters.'
        )]
        public string $surname,

        #[Assert\NotBlank(message: 'Email is required.')]
        #[Assert\Email(message: 'The email {{ value }} is not a valid email.')]
        #[Assert\Length(
            max: 100,
            maxMessage: 'Email cannot be longer than {{ limit }} characters.'
        )]
        public string $email,

        #[Assert\NotBlank(message: 'Phone number is required.')]
        #[Assert\Type(type: 'string')]
        #[Assert\Length(
            min: 5,
            max: 15,
            minMessage: 'Phone number must be at least {{ limit }} characters long.',
            maxMessage: 'Phone number cannot be longer than {{ limit }} characters.'
        )]
        #[Assert\Regex(
            pattern: '/^\+?[0-9]{9,15}$/',
            message: 'Invalid phone number format.'
        )]
        public string $phoneNumber,
    ) {
    }

    public static function fromRequest(array $data): self
    {
        return new self(
            startDate: (int)$data['startDate'],
            endDate: (int)$data['endDate'],
            name: $data['name'],
            surname: $data['surname'],
            email: $data['email'],
            phoneNumber: $data['phoneNumber']
        );
    }

    public function getStartDateTime(): \DateTime
    {
        return (new \DateTime())->setTimestamp($this->startDate)->setTime(0, 0, 0);
    }

    public function getEndDateTime(): \DateTime
    {
        return (new \DateTime())->setTimestamp($this->endDate)->setTime(0, 0, 0);
    }

    public function getDateRange(): array
    {
        $dates = [];
        $current = clone $this->getStartDateTime();
        $end = $this->getEndDateTime();

        while ($current <= $end) {
            $dates[] = clone $current;
            $current->modify('+1 day');
        }

        return $dates;
    }
}
