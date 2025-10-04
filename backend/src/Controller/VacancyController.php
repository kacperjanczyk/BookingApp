<?php

namespace App\Controller;

use App\Entity\Vacancy;
use App\Form\VacancyType;
use App\Repository\VacancyRepository;
use App\Service\VacancyService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/vacancies', name: 'admin_vacancy_')]
class VacancyController extends AbstractController
{
    public function __construct(
        private readonly VacancyRepository  $vacancyRepository,
        private readonly VacancyService     $vacancyService,
    ) {
    }

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(): Response
    {
        $vacancies = $this->vacancyRepository->findAll();

        return $this->render('vacancy/index.html.twig', [
            'vacancies' => $vacancies,
        ]);
    }

    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $vacancy = new Vacancy();
        $form = $this->createForm(VacancyType::class, $vacancy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->vacancyService->createVacancy($vacancy);
                $this->addFlash('success', 'Vacancy created successfully.');
                return $this->redirectToRoute('admin_vacancy_index');
            } catch (\InvalidArgumentException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('vacancy/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit/{id}', name: 'edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Vacancy $vacancy): Response
    {
        $form = $this->createForm(VacancyType::class, $vacancy);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $this->vacancyService->updateVacancy($vacancy);
                $this->addFlash('success', 'Vacancy updated successfully.');
                return $this->redirectToRoute('admin_vacancy_index');
            } catch (\InvalidArgumentException $e) {
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('vacancy/edit.html.twig', [
            'form' => $form->createView(),
            'vacancy' => $vacancy,
        ]);
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['POST'])]
    public function delete(Request $request, Vacancy $vacancy): Response
    {
        if (!$this->isCsrfTokenValid('delete'.$vacancy->getId(), $request->request->get('_token'))) {
            $this->addFlash('error', 'Invalid CSRF token.');
            return $this->redirectToRoute('admin_vacancy_index');
        }

        try {
            $this->vacancyService->deleteVacancy($vacancy);
            $this->addFlash('success', 'Vacancy deleted successfully.');
        } catch (\RuntimeException $e) {
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('admin_vacancy_index');
    }
}
