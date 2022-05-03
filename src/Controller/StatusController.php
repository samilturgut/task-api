<?php

namespace App\Controller;

use App\Enum\Status;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends BaseController
{
    #[Route('/api/status', name: 'api.statusList', methods: ['GET'])]
    public function statusList(): JsonResponse
    {
        return $this->_success(Status::$statusList);
    }
    
}