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
        return $this->render('home/index.html.twig', [
            'informations' => $informationRepository->findAll(),
            'comments' => $commentRepository->findBy(['isVisible' => true]),
            'habitats' => $habitatsRepository->findAll(),
            'services' => $servicesRepository->findAll(),
            'animals' => $animalsRepository->findAll(),
        ]);
    }
}
