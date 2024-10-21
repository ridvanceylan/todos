<?php
namespace App\Command;

use App\Service\TodoProviderFactory;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Todo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchTodoListFromApiCommand extends Command
{
    protected static $defaultName = 'app:fetch-todo-list-from-api';

    private $entityManager;
    private $todoProviderFactory;

    public function __construct(EntityManagerInterface $entityManager, TodoProviderFactory $todoProviderFactory)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->todoProviderFactory = $todoProviderFactory;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $providers = ['api1', 'api2'];

        foreach ($providers as $providerName) {
            $provider = $this->todoProviderFactory->createProvider($providerName);
            $tasks = $provider->fetchTasks();

            if (empty($tasks)) {
                continue; 
            }

            foreach ($tasks as $taskData) {
                $task = new Todo();

                if (array_key_exists('estimated_duration', $taskData)) {
                    
                    $task->setEstimatedDuration($taskData['estimated_duration']);
                    $task->setDifficulty($taskData['value']);
                    $task->setTaskId($taskData['id']);
                } elseif (array_key_exists('sure', $taskData)) {
                    
                    $task->setEstimatedDuration($taskData['sure']);
                    $task->setDifficulty($taskData['zorluk']);
                    $task->setTaskId($taskData['id']);
                } else {
                    continue;
                }

                $this->entityManager->persist($task);
            }
        }

        $this->entityManager->flush();

        return 0;
    }
}
