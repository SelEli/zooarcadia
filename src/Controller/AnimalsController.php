<?php

namespace App\Controller;

use App\Entity\Animals;
use App\Form\AnimalsType;
use App\Repository\AnimalsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/animals')]
final class AnimalsController extends AbstractController
{
    #[Route(name: 'app_animals_index', methods: ['GET'])]
    public function index(AnimalsRepository $animalsRepository): Response
    {
        $animals = $animalsRepository->findAll();

        // Convertir les données des images en base64
        foreach ($animals as $animal) {
            if ($animal->getImage()) {
                $image = $animal->getImage();
                $imageData = $image->getData();
                if (is_resource($imageData)) {
                    $imageData = stream_get_contents($imageData);
                }
                $image->setData(base64_encode($imageData));
            }
        }

        return $this->render('animals/index.html.twig', [
            'animals' => $animals,
        ]);
    }

    #[Route('/new', name: 'app_animals_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = new Animals();
        $form = $this->createForm(AnimalsType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($animal);
            $entityManager->flush();

            return $this->redirectToRoute('app_animals_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animals/new.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animals_show', methods: ['GET'])]
    public function show(Animals $animal, EntityManagerInterface $entityManager): Response
    {
        // Convertir les données des images en base64
        if ($animal->getImage()) {
            $image = $animal->getImage();
            $imageData = $image->getData();
            if (is_resource($imageData)) {
                $imageData = stream_get_contents($imageData);
            }
            $image->setData(base64_encode($imageData));
        }

        // Incrémenter le compteur de clics
        $animal->incrementClicks();
        $entityManager->flush();

        return $this->render('animals/show.html.twig', [
            'animal' => $animal,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_animals_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Animals $animal, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AnimalsType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_animals_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animals/edit.html.twig', [
            'animal' => $animal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_animals_delete', methods: ['POST'])]
    public function delete(Request $request, Animals $animal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$animal->getId(), $request->request->get('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animals_index', [], Response::HTTP_SEE_OTHER);
    }
}
