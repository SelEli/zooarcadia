<?php

namespace App\Controller;

use App\Repository\InformationsRepository;
use App\Repository\CommentsRepository;
use App\Repository\HabitatsRepository;
use App\Repository\ServicesRepository;
use App\Repository\AnimalsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        InformationsRepository $informationRepository,
        CommentsRepository $commentRepository,
        HabitatsRepository $habitatsRepository,
        ServicesRepository $servicesRepository,
        AnimalsRepository $animalsRepository
    ): Response {
        // Récupérer toutes les informations nécessaires
        $informations = $informationRepository->findAll();
        $comments = $commentRepository->findBy(['isVisible' => true]);
        $habitats = $habitatsRepository->findAll();
        $services = $servicesRepository->findAll();
        $animals = $animalsRepository->findAll();

        // Convertir les données des images des habitats et des animaux en base64
        foreach ($habitats as $habitat) {
            if ($habitat->getImage()) {
                $image = $habitat->getImage();
                $imageData = $image->getData();
                if (is_resource($imageData)) {
                    $imageData = stream_get_contents($imageData);
                }
                $image->setData(base64_encode($imageData));
            }
        }

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

        foreach ($services as $service) {
            if ($service->getImage()) {
                $image = $service->getImage();
                $imageData = $image->getData();
                if (is_resource($imageData)) {
                    $imageData = stream_get_contents($imageData);
                }
                $image->setData(base64_encode($imageData));
            }
        }

        return $this->render('home/index.html.twig', [
            'informations' => $informations,
            'comments' => $comments,
            'habitats' => $habitats,
            'services' => $services,
            'animals' => $animals,
        ]);
    }
}
