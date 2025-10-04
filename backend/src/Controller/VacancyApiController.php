<?php

namespace App\Controller;

use App\Dto\GetVacanciesRequestDto;
use App\Service\VacancyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/vacancies', name: 'api_vacancy_')]
class VacancyApiController extends AbstractController
{
    public function __construct(
        private readonly VacancyService $vacancyService
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $dto = GetVacanciesRequestDto::fromRequest($request->query->all());
        $vacancies = $this->vacancyService->getAvailableVacancies($dto);

        return $this->json([
            'message' => count($vacancies) . ' vacancies found.',
            'data' => $vacancies,
        ]);
    }
}
