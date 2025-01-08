<?php

namespace App\Controller;

use App\Entity\Habitats;
use App\Entity\Images;
use App\Form\HabitatsType;
use App\Repository\HabitatsRepository;
use App\Repository\AnimalsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;

#[Route('/habitats')]
final class HabitatsController extends AbstractController
{
    #[Route(name: 'app_habitats_index', methods: ['GET'])]
    public function index(HabitatsRepository $habitatsRepository): Response
    {
        $habitats = $habitatsRepository->findAll();

        foreach ($habitats as $habitat) {
            if ($habitat->getImage() && is_resource($habitat->getImage()->getData())) {
                $imageData = stream_get_contents($habitat->getImage()->getData());
                $habitat->getImage()->setData($imageData);
            }
        }

        return $this->render('habitats/index.html.twig', [
            'habitats' => $habitats,
        ]);
    }

    #[Route('/new', name: 'app_habitats_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $habitat = new Habitats();
        $form = $this->createForm(HabitatsType::class, $habitat);
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
                $habitat->setImage($image); // Assurez-vous que l'entité Habitats a une relation avec Images
            }

            $entityManager->persist($habitat);
            $entityManager->flush();

            return $this->redirectToRoute('app_habitats_index', [], Response::HTTP_SEE_OTHER);
        }
        
        return $this->render('habitats/new.html.twig', [
            'habitat' => $habitat,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_habitats_show', methods: ['GET'])]
    public function show(Habitats $habitat, AnimalsRepository $animalsRepository): Response
    {
        if ($habitat->getImage() && is_resource($habitat->getImage()->getData())) {
            $imageData = stream_get_contents($habitat->getImage()->getData());
            $habitat->getImage()->setData($imageData);
        }

        $animals = $animalsRepository->findBy(['habitat' => $habitat]);

        return $this->render('habitats/show.html.twig', [
            'habitat' => $habitat,
            'animals' => $animals,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_habitats_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Habitats $habitat, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HabitatsType::class, $habitat);
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
                $habitat->setImage($image);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_habitats_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('habitats/edit.html.twig', [
            'habitat' => $habitat,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_habitats_delete', methods: ['POST'])]
    public function delete(Request $request, Habitats $habitat, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $habitat->getId(), $request->request->get('_token'))) {
            $entityManager->remove($habitat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_habitats_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/animals', name: 'app_habitats_animals', methods: ['GET'])]
    public function getAnimals(Habitats $habitat, AnimalsRepository $animalsRepository, LoggerInterface $logger): Response
    {
        try {
            $logger->info("Starting to load animals for habitat ID: {$habitat->getId()}");

            $animals = $animalsRepository->findBy(['habitat' => $habitat]);

            $animalData = [];
            foreach ($animals as $animal) {
                if ($animal->getImage() && is_resource($animal->getImage()->getData())) {
                    $imageData = stream_get_contents($animal->getImage()->getData());
                    $animal->getImage()->setData($imageData);
                }

                $animalData[] = [
                    'id' => $animal->getId(),
                    'name' => $animal->getName(),
                    'imageType' => $animal->getImage()->getImageType(),
                    'imageData' => base64_encode($animal->getImage()->getData()),
                ];
            }

            $html = $this->renderView('habitats/_animals_list.html.twig', [
                'animals' => $animalData,
            ]);

            $logger->info("Successfully rendered animals list for habitat ID: {$habitat->getId()}");

            return new JsonResponse(['html' => $html]);

        } catch (\Exception $e) {
            $logger->error("Error loading animals for habitat ID: {$habitat->getId()}: " . $e->getMessage());
            return new JsonResponse(['html' => '<p class="text-center text-danger">Error loading animals. Please try again later.</p>'], 500);
        }
    }
}
