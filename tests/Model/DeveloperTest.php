<?php

namespace App\Tests\Model;

use App\Model\Developer;
use App\Entity\Todo;
use PHPUnit\Framework\TestCase;

class DeveloperTest extends TestCase
{
    public function testAssignTask()
    {
        $developer = new Developer('DEV1', 5, 40);
        $task = new Todo();
        $task->setDifficulty(2);
        $task->setEstimatedDuration(10); // 20 iş birimi

        $this->assertTrue($developer->assignTask($task)); // Görev atanabilmeli
        $this->assertEquals(180, $developer->getCapacity()); // Kalan kapasite kontrolü
    }

    public function testAssignTaskInsufficientCapacity()
    {
        $developer = new Developer('DEV1', 1, 8); 
        $task = new Todo();
        $task->setDifficulty(5); 
        $task->setEstimatedDuration(10); 
    
        $this->assertFalse($developer->assignTask($task));
    }
    

    public function testResetWorkload()
    {
        $developer = new Developer('DEV1', 5, 40);
        $task = new Todo();
        $task->setDifficulty(1);
        $task->setEstimatedDuration(5); // 5 iş birimi

        $developer->assignTask($task);
        $this->assertEquals(195, $developer->getCapacity()); // Kalan kapasite kontrolü

        $developer->resetWorkload();
        $this->assertEquals(200, $developer->getCapacity()); // Kapasite sıfırlanmalı
    }

    public function testGetTotalWorkload()
    {
        $developer = new Developer('DEV1', 5, 40);
        $task1 = new Todo();
        $task1->setDifficulty(2);
        $task1->setEstimatedDuration(10); // 20 iş birimi
        $developer->assignTask($task1);

        $task2 = new Todo();
        $task2->setDifficulty(1);
        $task2->setEstimatedDuration(5); // 5 iş birimi
        $developer->assignTask($task2);

        $this->assertEquals(25, $developer->getTotalWorkload()); // Toplam iş yükü
    }
}
