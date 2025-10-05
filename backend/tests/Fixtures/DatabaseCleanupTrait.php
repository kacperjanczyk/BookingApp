<?php

namespace App\Tests\Fixtures;

use Doctrine\ORM\EntityManagerInterface;

trait DatabaseCleanupTrait
{
    private function cleanupDatabase(EntityManagerInterface $entityManager): void
    {
        $entityManager->createQuery('DELETE FROM App\Entity\ReservationVacancy')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Reservation')->execute();
        $entityManager->createQuery('DELETE FROM App\Entity\Vacancy')->execute();
    }
}
