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
    private $animalsController;

    public function __construct(AnimalsController $animalsController)
    {
        $this->animalsController = $animalsController;
    }

    #[Route(name: 'app_habitats_index', methods: ['GET'])]
    public function index(HabitatsRepository $habitatsRepository): Response
    {
        $habitats = $habitatsRepository->findAll();

        // Convertir les données des images en chaînes de caractères
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
        // Convertir les données des images en chaînes de caractères
        if ($habitat->getImage() && is_resource($habitat->getImage()->getData())) {
            $imageData = stream_get_contents($habitat->getImage()->getData());
            $habitat->getImage()->setData($imageData);
        }

        // Récupérer les animaux associés à cet habitat via le repository
        $animals = $animalsRepository->findBy(['habitat' => $habitat]);

        // Convertir les images des animaux en chaînes de caractères via AnimalsController
        $this->animalsController->convertImages($animals);

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
                $habitat->setImage($image); // Assurez-vous que l'entité Habitats a une relation avec Images
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
        if ($this->isCsrfTokenValid('delete'.$habitat->getId(), $request->request->get('_token'))) {
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

            // Récupère les animaux associés à cet habitat en appelant le contrôleur des animaux
            $response = $this->forward('App\Controller\AnimalsController::getAnimalsByHabitat', [
                'habitatId' => $habitat->getId()
            ]);

            $data = json_decode($response->getContent(), true);
            $logger->info("Received data from AnimalsController: " . print_r($data, true));

            $html = $this->renderView('habitats/_animals_list.html.twig', [
                'animals' => $data['animals'],
            ]);

            $logger->info("Successfully rendered animals list for habitat ID: {$habitat->getId()}");

            return new JsonResponse(['html' => $html]);

        } catch (\Exception $e) {
            $logger->error("Error loading animals for habitat ID: {$habitat->getId()}: " . $e->getMessage());
            return new JsonResponse(['html' => '<p class="text-center text-danger">Error loading animals. Please try again later.</p>'], 500);
        }
    }
}
