<?php

namespace App\Controller;

use App\Enum\TaskPriority;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PriorityController extends BaseController
{
    #[Route('/api/priority', name: 'api.priorityList', methods: ['GET'])]
    public function priorityList(): JsonResponse
    {
        return $this->_success(TaskPriority::$priorityList);
    }
    
}