<?php

namespace App\Controller;

use App\Entity\Races;
use App\Form\RacesType;
use App\Repository\RacesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/races')]
final class RacesController extends AbstractController
{
    #[Route(name: 'app_races_index', methods: ['GET'])]
    public function index(RacesRepository $racesRepository): Response
    {
        return $this->render('races/index.html.twig', [
            'races' => $racesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_races_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $race = new Races();
        $form = $this->createForm(RacesType::class, $race);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($race);
            $entityManager->flush();

            return $this->redirectToRoute('app_races_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/new.html.twig', [
            'race' => $race,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_show', methods: ['GET'])]
    public function show(Races $race): Response
    {
        return $this->render('races/show.html.twig', [
            'race' => $race,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_races_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Races $race, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RacesType::class, $race);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_races_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('races/edit.html.twig', [
            'race' => $race,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_races_delete', methods: ['POST'])]
    public function delete(Request $request, Races $race, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$race->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($race);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_races_index', [], Response::HTTP_SEE_OTHER);
    }
}
