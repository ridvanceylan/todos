<?php

namespace App\Service;

use App\Model\Developer;
use App\Entity\Todo;

class TaskAssigner
{
    private $developers;

    public function __construct()
    {
        $this->developers = [
            new Developer('DEV1', 1, 45),
            new Developer('DEV2', 2, 45),
            new Developer('DEV3', 3, 45), 
            new Developer('DEV4', 4, 45), 
            new Developer('DEV5', 5, 45), 
        ];
    }

    public function assignTasks(array $tasks)
    {
        usort($tasks, function (Todo $a, Todo $b) {
            return $b->getDifficulty() <=> $a->getDifficulty() ?: $b->getEstimatedDuration() <=> $a->getEstimatedDuration();
        });

        $assignments = [];
        $totalWorkUnits = 0;

        foreach ($tasks as $task) {
            $taskWorkUnits = $task->getDifficulty() * $task->getEstimatedDuration();
            $totalWorkUnits += $taskWorkUnits; 

            $availableDevelopers = array_filter($this->developers, function (Developer $developer) use ($taskWorkUnits) {
                return $developer->getCapacity() >= $taskWorkUnits; 
            });

            if (!empty($availableDevelopers)) {
                usort($availableDevelopers, function (Developer $a, Developer $b) {
                    return $a->getTotalWorkload() <=> $b->getTotalWorkload(); 
                });

                $selectedDeveloper = $availableDevelopers[0];
                $selectedDeveloper->assignTask($task); 
                $assignments[] = [
                    'taskId' => $task->getTaskId(),
                    'developer' => $selectedDeveloper->getName()
                ];
            }
        }

        $maxCapacity = max(array_map(function (Developer $developer) {
            return $developer->getCapacity();
        }, $this->developers));

        $totalWorkload = 0;
        $totalCapacity = 0;
        
        foreach ($this->developers as $developer) {
            $workload = $developer->getTotalWorkload();
            $totalWorkload += $workload;
            $totalCapacity += $developer->getWeeklyHours() * $developer->getUnitCapacity();
        }

        $totalWeeks = ($totalCapacity > 0) ? ceil($totalWorkload / $totalCapacity) : 0;
        return [
            'assignments' => $assignments,
            'totalWeeks' => $totalWeeks
        ];
    }
}
