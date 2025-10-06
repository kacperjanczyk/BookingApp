<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\ReservationRepository;
use App\Service\ReservationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/reservations', name: 'admin_reservations_')]
final class ReservationController extends AbstractController
{
    public function __construct(
        private readonly ReservationRepository $reservationRepository,
        private readonly ReservationService $reservationService
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $reservations = $this->reservationRepository->findActive();

        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
        ]);
    }

    #[Route('/confirm/{id}', name: 'confirm', methods: ['GET'])]
    public function confirm(Reservation $reservation): Response
    {
        try {
            $this->reservationService->confirmReservation($reservation);
            $this->addFlash('success', 'Reservation confirmed successfully.');
        } catch (\LogicException $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_reservations_index');
    }
}
