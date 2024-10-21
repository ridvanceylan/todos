<?php

namespace App\Controller;

use App\Entity\Todo;
use App\Service\TaskAssigner;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    private $entityManager;
    private $taskAssigner;

    public function __construct(EntityManagerInterface $entityManager, TaskAssigner $taskAssigner)
    {
        $this->entityManager = $entityManager;
        $this->taskAssigner = $taskAssigner;
    }

    /**
     * @Route("/assign-tasks", name="assign_tasks")
     */
    public function assignTasks(): Response
    {

        $tasks = $this->entityManager->getRepository(Todo::class)->findAll();

        $assignments = $this->taskAssigner->assignTasks($tasks);

        return $this->render('task/assignments.html.twig', [
            'assignments' => $assignments,
        ]);
    }
}
