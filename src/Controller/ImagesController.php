<?php

namespace App\Controller;

use App\Entity\Images;
use App\Form\ImagesType;
use App\Repository\ImagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/images')]
final class ImagesController extends AbstractController
{
    #[Route(name: 'app_images_index', methods: ['GET'])]
    public function index(ImagesRepository $imagesRepository): Response
    {
        $images = $imagesRepository->findAll();

        // Convertir les données des images en chaînes de caractères
        foreach ($images as $image) {
            $imageData = stream_get_contents($image->getData());
            $image->setData($imageData);
        }

        return $this->render('images/index.html.twig', [
            'images' => $images,
        ]);
    }

    #[Route('/new', name: 'app_images_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $image = new Images();
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

            if ($file) {
                $imageData = file_get_contents($file->getPathname());
                $image->setData($imageData);

                $mimeType = $file->getMimeType();
                $image->setImageType($mimeType);

                $filename = $file->getClientOriginalName();
                $image->setFilename($filename);
            }

            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('images/new.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_images_show', methods: ['GET'])]
    public function show(Images $image): Response
    {
        $imageData = stream_get_contents($image->getData());
        $image->setData($imageData);

        return $this->render('images/show.html.twig', [
            'image' => $image,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_images_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Images $image, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ImagesType::class, $image);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('imageFile')->getData();

            if ($file) {
                $imageData = file_get_contents($file->getPathname());
                $image->setData($imageData);

                $mimeType = $file->getMimeType();
                $image->setImageType($mimeType);

                $filename = $file->getClientOriginalName();
                $image->setFilename($filename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_images_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('images/edit.html.twig', [
            'image' => $image,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_images_delete', methods: ['POST'])]
    public function delete(Request $request, Images $image, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $request->request->get('_token'))) {
            $entityManager->remove($image);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_images_index', [], Response::HTTP_SEE_OTHER);
    }
}
