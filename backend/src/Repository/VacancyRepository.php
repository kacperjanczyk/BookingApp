<?php

namespace App\Repository;

use App\Entity\Vacancy;
use App\Query\FindAvailableVacanciesQuery;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Vacancy>
 */
class VacancyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vacancy::class);
    }

    public function findByQuery(FindAvailableVacanciesQuery $query): array
    {
        $qb = $this->createQueryBuilder('v')
            ->where('v.availableCount > 0');

        if ($query->getStartDateTime()) {
            $qb->andWhere('v.date >= :startDate')
               ->setParameter('startDate', $query->getStartDateTime());
        }

        if ($query->getEndDateTime()) {
            $qb->andWhere('v.date <= :endDate')
               ->setParameter('endDate', $query->getEndDateTime());
        }

        return $qb->orderBy('v.date', 'ASC')
                  ->getQuery()
                  ->getResult();
    }

    public function findOneAvailableForDate(\DateTime $date): ?Vacancy
    {
        return $this->createQueryBuilder('v')
            ->where('v.date = :date')
            ->andWhere('v.availableCount > 0')
            ->setParameter('date', $date)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
