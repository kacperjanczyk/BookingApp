<?php

namespace App\Controller;

use App\Dto\CreateReservationDto;
use App\Dto\ReservationResponseDto;
use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/reservations', name: 'api_reservation_')]
final class ReservationApiController extends AbstractController
{
    public function __construct(
        private readonly ReservationService     $reservationService,
        private readonly ReservationRepository  $reservationRepository,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $reservations = $this->reservationRepository->findActive();

        return $this->json([
            'message' => count($reservations) . ' reservations found.',
            'data' => $reservations,
        ]);
    }

    #[Route('', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $dto = CreateReservationDto::fromRequest($data);
            $reservation = $this->reservationService->createReservation($dto);

            return $this->json([
                'message' => 'Reservation created successfully.',
                'data' => ReservationResponseDto::fromEntity($reservation)
            ], JsonResponse::HTTP_CREATED);
        } catch (\InvalidArgumentException|\RuntimeException $e) {
            return $this->json(['error' => $e->getMessage()], JsonResponse::HTTP_BAD_REQUEST);
        }
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    public function delete(Reservation $reservation): JsonResponse
    {
        $this->reservationService->cancelReservation($reservation);

        return $this->json([
            'message' => 'Reservation cancelled successfully.',
        ]);
    }
}
