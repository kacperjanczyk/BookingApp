<?php

namespace App\Tests\Fixtures;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait ApiTestHelperTrait
{
    private function createVacancies(array $vacancies, EntityManagerInterface $entityManager): void
    {
        foreach ($vacancies as $vacancy) {
            $entityManager->persist($vacancy);
        }
        $entityManager->flush();
    }

    private function getResponseData(KernelBrowser $client): array
    {
        return json_decode($client->getResponse()->getContent(), true);
    }
}
