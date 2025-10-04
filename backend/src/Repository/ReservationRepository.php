<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function findActive(): array
    {
        $qb = $this->createQueryBuilder('r')
            ->where('r.status IN (:activeStatuses)')
            ->setParameter('activeStatuses', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
            ->orderBy('r.startDate', 'ASC');

        $results = $qb->getQuery()->getArrayResult();
        foreach ($results as $key => $result) {
            $results[$key]['status'] = Reservation::STATUS_LABELS[$result['status']];
        }

        return $results;
    }
}
