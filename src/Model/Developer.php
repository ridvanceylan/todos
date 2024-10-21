<?php
namespace App\Model;

use App\Entity\Todo;

class Developer
{
    private $name;
    private $unitCapacity;
    private $weeklyHours;
    private $remainingWorkload;
    private $assignedTasks = [];

    public function __construct($name, $unitCapacity, $weeklyHours)
    {
        $this->name = $name;
        $this->unitCapacity = $unitCapacity;
        $this->weeklyHours = $weeklyHours;
        $this->remainingWorkload = $weeklyHours * $unitCapacity;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getCapacity()
    {
        return $this->remainingWorkload;
    }

    public function getAssignedTasks()
    {
        return $this->assignedTasks;
    }

    public function getWeeklyHours()
    {
        return $this->weeklyHours;
    }

    public function getUnitCapacity()
    {
        return $this->unitCapacity;
    }

    public function assignTask(Todo $task)
    {
        $taskWorkUnits = $task->getDifficulty() * $task->getEstimatedDuration();
        if ($this->remainingWorkload >= $taskWorkUnits) {
            $this->remainingWorkload -= $taskWorkUnits;
            $this->assignedTasks[] = $task;
            return true; 
        }
        return false;
    }

    public function resetWorkload()
    {
        $this->remainingWorkload = $this->weeklyHours * $this->unitCapacity;
    }

    public function getTotalWorkload()
    {
        return array_reduce($this->assignedTasks, function ($total, Todo $task) {
            return $total + ($task->getDifficulty() * $task->getEstimatedDuration());
        }, 0);
    }
}
