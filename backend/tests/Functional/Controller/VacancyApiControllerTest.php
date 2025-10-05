<?php

namespace App\Tests\Functional\Controller;

use App\Tests\Fixtures\ApiTestHelperTrait;
use App\Tests\Fixtures\DatabaseCleanupTrait;
use App\Tests\Fixtures\ReservationFixtures;
use App\Tests\Fixtures\VacancyMother;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class VacancyApiControllerTest extends WebTestCase
{
    use DatabaseCleanupTrait;
    use ApiTestHelperTrait;

    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = static::getContainer()->get('doctrine')->getManager();
        $this->cleanupDatabase($this->entityManager);
    }

    public function testGetVacanciesWithoutFilters(): void
    {
        $this->createVacancies([
            VacancyMother::createAvailable(ReservationFixtures::DEFAULT_START_TIMESTAMP),
            VacancyMother::createAvailable(ReservationFixtures::DEFAULT_START_TIMESTAMP + 86400),
        ], $this->entityManager);

        $this->client->request('GET', '/api/vacancies');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');

        $responseData = $this->getResponseData($this->client);

        $this->assertArrayHasKey('data', $responseData);
        $this->assertCount(2, $responseData['data']);
    }

    public function testGetVacanciesWithDateFilters(): void
    {
        $this->createVacancies([
            VacancyMother::createForDate(ReservationFixtures::DEFAULT_START_TIMESTAMP, 100.0, 10, 5),
            VacancyMother::createForDate(ReservationFixtures::DEFAULT_START_TIMESTAMP + 86400, 150.0, 10, 8),
            VacancyMother::createForDate(ReservationFixtures::DEFAULT_END_TIMESTAMP, 200.0, 15, 10)
        ], $this->entityManager);

        $this->client->request('GET', '/api/vacancies', [
            'startDate' => ReservationFixtures::DEFAULT_START_TIMESTAMP,
            'endDate' => ReservationFixtures::DEFAULT_START_TIMESTAMP + 86400,
        ]);

        $this->assertResponseIsSuccessful();

        $responseData = $this->getResponseData($this->client);

        $this->assertArrayHasKey('data', $responseData);
        $this->assertCount(2, $responseData['data']);
    }

    public function testGetVacanciesOnlyAvailable(): void
    {
        $this->createVacancies([
            VacancyMother::createAvailable(ReservationFixtures::DEFAULT_START_TIMESTAMP),
            VacancyMother::createFullyBoocked(ReservationFixtures::DEFAULT_START_TIMESTAMP + 86400),
        ], $this->entityManager);

        $this->client->request('GET', '/api/vacancies');

        $responseData = $this->getResponseData($this->client);

        $this->assertArrayHasKey('data', $responseData);
        $this->assertCount(1, $responseData['data']);
        $this->assertEquals(
            ReservationFixtures::DEFAULT_START_TIMESTAMP,
            (new \DateTime($responseData['data'][0]['date']))->getTimestamp()
        );
    }
}
