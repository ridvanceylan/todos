<?php
namespace App\Service;

interface TodoProviderInterface
{
    public function fetchTasks(): array;
}
