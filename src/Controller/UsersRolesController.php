<?php

namespace App\Controller;

use App\Entity\UsersRoles;
use App\Form\UsersRolesType;
use App\Repository\UsersRolesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/users/roles')]
final class UsersRolesController extends AbstractController
{
    #[Route(name: 'app_users_roles_index', methods: ['GET'])]
    public function index(UsersRolesRepository $usersRolesRepository): Response
    {
        return $this->render('users_roles/index.html.twig', [
            'users_roles' => $usersRolesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_users_roles_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $usersRole = new UsersRoles();
        $form = $this->createForm(UsersRolesType::class, $usersRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($usersRole);
            $entityManager->flush();

            return $this->redirectToRoute('app_users_roles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('users_roles/new.html.twig', [
            'users_role' => $usersRole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_users_roles_show', methods: ['GET'])]
    public function show(UsersRoles $usersRole): Response
    {
        return $this->render('users_roles/show.html.twig', [
            'users_role' => $usersRole,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_users_roles_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, UsersRoles $usersRole, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UsersRolesType::class, $usersRole);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_users_roles_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('users_roles/edit.html.twig', [
            'users_role' => $usersRole,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_users_roles_delete', methods: ['POST'])]
    public function delete(Request $request, UsersRoles $usersRole, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$usersRole->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($usersRole);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_users_roles_index', [], Response::HTTP_SEE_OTHER);
    }
}
