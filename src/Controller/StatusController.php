<?php

namespace App\Controller;

use App\Enum\Status;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class StatusController extends BaseController
{
    #[Route('/api/status', name: 'api.statusList', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function statusList(): JsonResponse
    {
        return $this->_success(Status::$statusList);
    }
    
}