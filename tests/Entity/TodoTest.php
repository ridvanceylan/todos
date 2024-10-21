<?php

namespace App\Tests\Entity;

use App\Entity\Todo;
use PHPUnit\Framework\TestCase;

class TodoTest extends TestCase
{
    public function testGettersAndSetters()
    {
        $todo = new Todo();
        $todo->setDifficulty(3);
        $todo->setEstimatedDuration(4);
        $todo->setTaskId(1);

        $this->assertEquals(3, $todo->getDifficulty());
        $this->assertEquals(4, $todo->getEstimatedDuration());
        $this->assertEquals(1, $todo->getTaskId());
    }
}
