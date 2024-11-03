<?php

namespace App\Controller;

use App\Entity\Comments;
use App\Form\CommentsType;
use App\Repository\CommentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/comments')]
class CommentsController extends AbstractController
{
    #[Route('/', name: 'app_comments_index', methods: ['GET'])]
    public function index(CommentsRepository $commentsRepository): Response
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
            // Utilisateur authentifié : retourne tous les commentaires
            $comments = $commentsRepository->findAll();
        } else {
            // Visiteur public : retourne uniquement les commentaires visibles
            $comments = $commentsRepository->findBy(['isVisible' => true]);
        }

        return $this->render('comments/index.html.twig', [
            'comments' => $comments,
        ]);
    }

    #[Route('/new', name: 'app_comments_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $comment = new Comments();
        $form = $this->createForm(CommentsType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comments/new.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_comments_show', methods: ['GET'])]
    public function show(Comments $comment): Response
    {
        // Vérifie que le commentaire est visible au public ou que l'utilisateur est connecté
        if (!$comment->isVisible() && !$this->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException('You do not have access to this comment.');
        }

        return $this->render('comments/show.html.twig', [
            'comment' => $comment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_comments_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Comments $comment, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommentsType::class, $comment); // Utilise le même formulaire
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('comments/edit.html.twig', [
            'comment' => $comment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_comments_delete', methods: ['POST'])]
    public function delete(Request $request, Comments $comment, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$comment->getId(), $request->request->get('_token'))) {
            $entityManager->remove($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/validate', name: 'app_comments_validate', methods: ['POST'])]
    public function validate(Comments $comment, EntityManagerInterface $entityManager): Response
    {
        $comment->setVisible(true);
        $entityManager->flush();

        return $this->redirectToRoute('app_comments_index', [], Response::HTTP_SEE_OTHER);
    }
}
