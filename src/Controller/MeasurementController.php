<?php

namespace App\Controller;

use App\Entity\Measurement;
use App\Form\MeasurementType;
use App\Repository\MeasurementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/measurement')]
final class MeasurementController extends AbstractController
{
    #[Route(name: 'app_measurement_index', methods: ['GET'])]
    #[IsGranted('ROLE_MEASUREMENT_INDEX')]
    public function index(MeasurementRepository $measurementRepository): Response
    {
        return $this->render('measurement/index.html.twig', [
            'measurements' => $measurementRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_measurement_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MEASUREMENT_NEW')]
    public function new(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $measurement = new Measurement();
        $form = $this->createForm(MeasurementType::class, $measurement);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Walidacja encji
            $errors = $validator->validate($measurement);

            if (count($errors) === 0 && $form->isValid()) {
                $entityManager->persist($measurement);
                $entityManager->flush();

                $this->addFlash('success', 'Pomiar został pomyślnie dodany!');
                return $this->redirectToRoute('app_measurement_index', [], Response::HTTP_SEE_OTHER);
            } else {
                // Dodaj błędy walidacji do flash messages
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            }
        }

        return $this->render('measurement/new.html.twig', [
            'measurement' => $measurement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measurement_show', methods: ['GET'])]
    #[IsGranted('ROLE_MEASUREMENT_SHOW')]
    public function show(Measurement $measurement): Response
    {
        return $this->render('measurement/show.html.twig', [
            'measurement' => $measurement,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_measurement_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_MEASUREMENT_EDIT')]
    public function edit(Request $request, Measurement $measurement, EntityManagerInterface $entityManager, ValidatorInterface $validator): Response
    {
        $form = $this->createForm(MeasurementType::class, $measurement);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Walidacja encji
            $errors = $validator->validate($measurement);

            if (count($errors) === 0 && $form->isValid()) {
                $entityManager->flush();

                $this->addFlash('success', 'Pomiar został pomyślnie zaktualizowany!');
                return $this->redirectToRoute('app_measurement_index', [], Response::HTTP_SEE_OTHER);
            } else {
                // Dodaj błędy walidacji do flash messages
                foreach ($errors as $error) {
                    $this->addFlash('error', $error->getMessage());
                }
            }
        }

        return $this->render('measurement/edit.html.twig', [
            'measurement' => $measurement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_measurement_delete', methods: ['POST'])]
    #[IsGranted('ROLE_MEASUREMENT_DELETE')]
    public function delete(Request $request, Measurement $measurement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$measurement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($measurement);
            $entityManager->flush();
            $this->addFlash('success', 'Pomiar został pomyślnie usunięty!');
        }

        return $this->redirectToRoute('app_measurement_index', [], Response::HTTP_SEE_OTHER);
    }
}
