<?php

namespace App\Controller;

use App\Entity\Animals;
use App\Entity\Images;
use App\Form\AnimalsType;
use App\Repository\AnimalsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/animals')]
final class AnimalsController extends AbstractController
{
    #[Route(name: 'app_animals_index', methods: ['GET'])]
    public function index(AnimalsRepository $animalsRepository): Response
    {
        $animals = $animalsRepository->findAll();

        // Convertir les données des images en chaînes de caractères
        foreach ($animals as $animal) {
            if ($animal->getImage() && is_resource($animal->getImage()->getData())) {
                $imageData = stream_get_contents($animal->getImage()->getData());
                $animal->getImage()->setData($imageData);
            }
        }

        return $this->render('animals/index.html.twig', [
            'animals' => $animals,
        ]);
    }

    public function convertImages(array $animals): void
    {
        foreach ($animals as $animal) {
            if ($animal->getImage() && is_resource($animal->getImage()->getData())) {
                $imageData = stream_get_contents($animal->getImage()->getData());
                $animal->getImage()->setData($imageData);
            }
        }
    }

    #[Route('/new', name: 'app_animals_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $animal = new Animals();
        $form = $this->createForm(AnimalsType::class, $animal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

            if ($file) {
                $imageData = file_get_contents($file->getPathname());
                $mimeType = $file->getMimeType();
                $filename = $file->getClientOriginalName();

                $image = new Images();
                $image->setData($imageData);
                $image->setImageType($mimeType);
                $image->setFilename($filename);

                $entityManager->persist($image);
                $animal->setImage($image);
            }

            $entityManager->persist($animal);
            $entityManager->flush();

            return $this->redirectToRoute('app_animals_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animals/new.html.twig', [
            'animal' => $animal,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_animals_show', methods: ['GET'])]
    public function show(Animals $animal, EntityManagerInterface $entityManager): Response
    {
        if ($animal->getImage() && is_resource($animal->getImage()->getData())) {
            $imageData = stream_get_contents($animal->getImage()->getData());
            $animal->getImage()->setData($imageData);
        }

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
            $file = $form->get('imageFile')->getData();

            if ($file) {
                $imageData = file_get_contents($file->getPathname());
                $mimeType = $file->getMimeType();
                $filename = $file->getClientOriginalName();

                $image = new Images();
                $image->setData($imageData);
                $image->setImageType($mimeType);
                $image->setFilename($filename);

                $entityManager->persist($image);
                $animal->setImage($image);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_animals_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('animals/edit.html.twig', [
            'animal' => $animal,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_animals_delete', methods: ['POST'])]
    public function delete(Request $request, Animals $animal, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $animal->getId(), $request->request->get('_token'))) {
            $entityManager->remove($animal);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_animals_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/habitat/{habitatId}', name: 'app_animals_by_habitat', methods: ['GET'])]
    public function getAnimalsByHabitat(int $habitatId, AnimalsRepository $animalsRepository): Response
    {
        $animals = $animalsRepository->findBy(['habitat' => $habitatId]);
        $this->convertImages($animals);

        $animalData = [];
        foreach ($animals as $animal) {
            $animalData[] = [
                'id' => $animal->getId(),
                'name' => $animal->getName(),
                'imageType' => $animal->getImage()->getImageType(),
                'imageData' => base64_encode($animal->getImage()->getData()),
            ];
        }

        return new JsonResponse(['animals' => $animalData]);
    }
}
