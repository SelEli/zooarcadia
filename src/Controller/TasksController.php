<?php

namespace App\Controller;

use App\Entity\Tasks;
use App\Form\TasksType;
use App\Repository\TasksRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tasks')]
final class TasksController extends AbstractController
{
    #[Route(name: 'app_tasks_index', methods: ['GET'])]
    public function index(TasksRepository $tasksRepository): Response
    {
        $user = $this->getUser();

        if ($this->isGranted('ROLE_ADMIN')) {
            $tasks = $tasksRepository->findAll();
        } else {
            $tasks = $tasksRepository->findBy(['user' => $user]);
        }

        return $this->render('tasks/index.html.twig', [
            'tasks' => $tasks,
        ]);
    }

    #[Route('/new', name: 'app_tasks_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $task = new Tasks();
        $form = $this->createForm(TasksType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setUser($this->getUser());
            $entityManager->persist($task);
            $entityManager->flush();

            return $this->redirectToRoute('app_tasks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tasks/new.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tasks_show', methods: ['GET'])]
    public function show(Tasks $task): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && $task->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You do not have access to this task.');
        }

        return $this->render('tasks/show.html.twig', [
            'task' => $task,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_tasks_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tasks $task, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && $task->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You do not have access to edit this task.');
        }

        $form = $this->createForm(TasksType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_tasks_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tasks/edit.html.twig', [
            'task' => $task,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_tasks_delete', methods: ['POST'])]
    public function delete(Request $request, Tasks $task, EntityManagerInterface $entityManager): Response
    {
        if (!$this->isGranted('ROLE_ADMIN') && $task->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You do not have access to delete this task.');
        }

        if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_tasks_index', [], Response::HTTP_SEE_OTHER);
    }
}
