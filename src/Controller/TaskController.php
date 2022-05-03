<?php

namespace App\Controller;

use App\Builder\Http\Exception\InvalidArgumentException;
use App\Builder\Http\Exception\ResponseException;
use App\Builder\Http\Request as RequestBuilder;
use App\Enum\Status;
use App\Forms\TaskForm;
use App\Service\TaskService;
use App\Validation\ValidationException;
use App\Validation\Validator;
use App\Validation\ValidatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class TaskController extends BaseController
{
    #[Route('/api/tasks', name: 'api.task', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function tasks(TaskService $taskService): JsonResponse
    {
        try {
            $tasks = $taskService->getTasks();
            
            return $this->_success($tasks);
        } catch (ExceptionInterface|\Exception $e) {
            $this->logger->error('Task list errors.', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw new ResponseException('Something went wrong!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
    #[Route('/api/task', name: 'api.createTask', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request, TaskService $taskService, ValidatorInterface $validator): JsonResponse
    {
        try {
            $request = new RequestBuilder($request);
            
            $taskForm = new TaskForm();
            $taskForm->setContent($request->getParameter('content', null));
            $taskForm->setCategories($request->getParameter('categories', null));
            $taskForm->setPriority($request->getParameter('priority', null));
            $taskForm->setStatus($request->getParameter('status', null));
    
            $validator->validate($taskForm);
            
            $task = $taskService->create($taskForm);
            
            return $this->_success($task, 201);
        } catch (ValidationException $e) {
            throw $e;
        } catch (InvalidArgumentException $e) {
            $this->logger->error('Task create request error.', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw new ResponseException('Parameters is invalid!', Response::HTTP_BAD_REQUEST);
        } catch (ExceptionInterface|\Exception $e) {
            $this->logger->error('Task create error.', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
    
    #[Route('/api/task/{id}/close', name: 'api.closeTask', methods: ['PUT'])]
    #[IsGranted('ROLE_EXPERT')]
    public function update(int $id, Request $request, TaskService $taskService, ValidatorInterface $validator): JsonResponse
    {
        try {
            $request = new RequestBuilder($request);
            $taskForm = new TaskForm();
            $taskForm->setCloseDescription($request->getParameter('closeDescription', null));
            
            $taskForm->setStatus(Status::CLOSED);
    
            $validator->validate($taskForm);
            
            $close = $taskService->close($taskForm, $id);
            
            return $this->_success(['close' => $close]);
    
        } catch (ValidationException $e) {
            throw $e;
        } catch (InvalidArgumentException $e) {
            $this->logger->error('Task create request error.', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
    
            throw new ResponseException('Parameters is invalid!', Response::HTTP_BAD_REQUEST);
        } catch (ExceptionInterface|\Exception $e) {
            $this->logger->error('Task list errors.', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw new ResponseException('Something went wrong!', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
