<?php

namespace App\Controller;

use App\Entity\Services;
use App\Entity\Images;
use App\Form\ServicesType;
use App\Repository\ServicesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/services')]
final class ServicesController extends AbstractController
{
    #[Route(name: 'app_services_index', methods: ['GET'])]
    public function index(ServicesRepository $servicesRepository): Response
    {
        $services = $servicesRepository->findAll();

        // Convertir les données des images en chaînes de caractères
        foreach ($services as $service) {
            if ($service->getImage() && is_resource($service->getImage()->getData())) {
                $imageData = stream_get_contents($service->getImage()->getData());
                $service->getImage()->setData($imageData);
            }
        }

        return $this->render('services/index.html.twig', [
            'services' => $services,
        ]);
    }

    #[Route('/new', name: 'app_services_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = new Services();
        $form = $this->createForm(ServicesType::class, $service);
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
                $service->setImage($image); // Assurez-vous que l'entité Services a une relation avec Images
            }

            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_services_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('services/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_services_show', methods: ['GET'])]
    public function show(Services $service): Response
    {
        if ($service->getImage() && is_resource($service->getImage()->getData())) {
            $imageData = stream_get_contents($service->getImage()->getData());
            $service->getImage()->setData($imageData);
        }

        return $this->render('services/show.html.twig', [
            'service' => $service,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_services_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Services $service, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServicesType::class, $service);
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
                $service->setImage($image); // Assurez-vous que l'entité Services a une relation avec Images
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_services_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('services/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_services_delete', methods: ['POST'])]
    public function delete(Request $request, Services $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_services_index', [], Response::HTTP_SEE_OTHER);
    }
}
