<?php

namespace App\Mapper;

use App\Entity\Category;
use App\Entity\Task;
use App\Enum\Status;
use App\Enum\TaskPriority;

class TaskMapper
{
    /**
     * @throws \Exception
     */
    public static function map(array $tasks): array
    {
        $mapped = [];
        /** @var Task $task */
        foreach ($tasks as $task) {
            
            $categories = [];
            /** @var Category $category */
            foreach ($task->getCategories() as $category) {
                $categories[] = [
                    'id' => $category->getId(),
                    'name' => $category->getName(),
                ];
            }
            
            $mapped[] = [
                'id' => $task->getId(),
                'content' => $task->getContent(),
                'status' => Status::getStatus($task->getStatus()),
                'priority' => TaskPriority::getPriority($task->getPriority()),
                'closeDescription' => $task->getCloseDescription(),
                'categories' => $categories,
                'createdAt' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
                'updatedAt' => !empty($task->getUpdatedAt()) ? $task->getUpdatedAt()->format('Y-m-d H:i:s') : null
            ];
        }
        
        return $mapped;
    }
}