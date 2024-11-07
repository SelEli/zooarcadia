<?php

namespace App\Controller;

use App\Entity\Habitats;
use App\Entity\Images;
use App\Form\HabitatsType;
use App\Repository\HabitatsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/habitats')]
final class HabitatsController extends AbstractController
{
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
    public function show(Habitats $habitat): Response
    {
        if ($habitat->getImage() && is_resource($habitat->getImage()->getData())) {
            $imageData = stream_get_contents($habitat->getImage()->getData());
            $habitat->getImage()->setData($imageData);
        }

        return $this->render('habitats/show.html.twig', [
            'habitat' => $habitat,
            'animals' => $habitat->getAnimals(),
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
}
