<?php

namespace App\Tests\Unit\Service;

use App\Entity\Vacancy;
use App\Service\VacancyAvailabilityService;
use App\Tests\Fixtures\VacancyMother;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class VacancyAvailabilityServiceTest extends TestCase
{
    private EntityManagerInterface $entityManager;
    private VacancyAvailabilityService $service;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->service = new VacancyAvailabilityService($this->entityManager);
    }

    public function testDecreaseAvailability(): void
    {
        $vacancy = VacancyMother::createWithSpotsAvailable();
        $initialCount = $vacancy->getAvailableCount();

        $this->expectPersist($vacancy);

        $this->service->decreaseAvailability($vacancy);

        $this->assertEquals($initialCount - 1, $vacancy->getAvailableCount());
    }

    public function testDecreaseAvailabilityThrowsExceptionWhenNoAvailableSpots(): void
    {
        $vacancy = VacancyMother::createEmpty();

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('No available vacancies left.');

        $this->service->decreaseAvailability($vacancy);
    }

    public function testIncreaseAvailability(): void
    {
        $vacancy = VacancyMother::createWithAvailableCount(3);
        $initalCount = $vacancy->getAvailableCount();

        $this->expectPersist($vacancy);

        $this->service->increaseAvailability($vacancy);

        $this->assertEquals($initalCount + 1, $vacancy->getAvailableCount());
    }

    private function expectPersist(object $entity): void
    {
        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($entity);
    }
}
