<?php

namespace App\Tests\Functional\Controller;

use App\Entity\Reservation;
use App\Tests\Fixtures\ApiTestHelperTrait;
use App\Tests\Fixtures\DatabaseCleanupTrait;
use App\Tests\Fixtures\ReservationFixtures;
use App\Tests\Fixtures\ReservationMother;
use App\Tests\Fixtures\VacancyMother;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ReservationApiControllerTest extends WebTestCase
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

    public function testCreateReservationSuccessfully(): void
    {
        $startDate = ReservationFixtures::DEFAULT_START_TIMESTAMP;
        $endDate = ReservationFixtures::DEFAULT_END_TIMESTAMP;

        $this->createVacanciesForDateRange($startDate, $endDate);

        $this->makeReservationRequest(ReservationFixtures::defaultRequestData());

        $this->assertResponseStatusCodeSame(201);

        $responseData = $this->getResponseData($this->client);

        $this->assertArrayHasKey('data', $responseData);
        $this->assertEquals(ReservationFixtures::DEFAULT_NAME, $responseData['data']['name']);
        $this->assertEquals(ReservationFixtures::DEFAULT_SURNAME, $responseData['data']['surname']);
        $this->assertEquals(300.0, $responseData['data']['price']);
    }

    public function testCreateReservationFailsWhenNoAvailability(): void
    {
        $this->createVacancies([
            VacancyMother::createFullyBoocked(ReservationFixtures::DEFAULT_START_TIMESTAMP)
        ], $this->entityManager);

        $requestData = ReservationFixtures::defaultRequestData();
        $requestData['endDate'] = ReservationFixtures::DEFAULT_START_TIMESTAMP;

        $this->makeReservationRequest($requestData);

        $this->assertResponseStatusCodeSame(400);

        $responseData = $this->getResponseData($this->client);
        $this->assertArrayHasKey('error', $responseData);
    }

    public function testGetReservations(): void
    {
        $reservation = ReservationMother::createDefaultPending();
        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        $this->client->request('GET', '/api/reservations');

        $this->assertResponseIsSuccessful();

        $responseData = $this->getResponseData($this->client);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertCount(1, $responseData['data']);
    }

    public function testDeleteReservation(): void
    {
        $reservation =ReservationMother::createDefaultPending();
        $this->entityManager->persist($reservation);
        $this->entityManager->flush();

        $reservationId = $reservation->getId();

        $this->client->request('DELETE', '/api/reservations/' . $reservationId);

        $this->assertResponseIsSuccessful();

        $this->entityManager->refresh($reservation);
        $this->assertEquals(Reservation::STATUS_CANCELLED, $reservation->getStatus());
    }

    private function createVacanciesForDateRange(int $startDate, int $endDate): void
    {
        $vacancies = [
            VacancyMother::createAvailable($startDate),
            VacancyMother::createAvailable($startDate + 86400),
            VacancyMother::createAvailable($endDate),
        ];

        $this->createVacancies($vacancies, $this->entityManager);
    }

    private function makeReservationRequest(array $requestData): void
    {
        $this->client->request(
            method: 'POST',
            uri: '/api/reservations',
            server: ['Content-Type' => 'application/json'],
            content: json_encode($requestData)
        );
    }
}
