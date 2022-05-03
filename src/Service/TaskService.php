<?php

namespace App\Service;

use App\Entity\Category;
use App\Entity\Task;
use App\Enum\Status;
use App\Enum\TaskPriority;
use App\Forms\TaskForm;
use App\Validation\ValidationException;
use Symfony\Component\Serializer\Exception\ExceptionInterface;

class TaskService extends AbstractService
{
    public function getTasks(): array
    {
        try {
            $user = $this->security->isGranted('ROLE_EXPERT') ? null : $this->security->getUser();
            $tasks = $this->_em->getRepository(Task::class)->findByUsers($user);
            
            return $this->serializer->normalize($tasks);
            
        } catch (ExceptionInterface $e) {
            $this->logger->error('Task normalize error!', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        } catch (\Exception $e) {
            $this->logger->error('Get tasks failed!', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }
    
    public function create(TaskForm $taskForm): array
    {
        try {
            $task = new Task();
            $task->setContent($taskForm->getContent());
            $task->setUser($this->security->getUser());
            $task->setPriority($taskForm->getPriority() ?? TaskPriority::NORMAL);
            $task->setStatus($taskForm->getStatus() ?? Status::ACTIVE);
    
            foreach ($taskForm->getCategories() as $categoryId) {
                $category = $this->_em->getRepository(Category::class)->find($categoryId);
                if (!$category) {
                    throw new ValidationException([], $categoryId . ' id category not found!');
                }
                $task->addCategory($category);
            }
            
            $this->_em->persist($task);
            $this->_em->flush();
            
            return [
                'id' => $task->getId(),
                'content' => $task->getContent(),
                'priority' => $task->getPriority(),
                'status' => $task->getStatus(),
                'userEmail' => $task->getUser()->getEmail(),
                'createdAt' => $task->getCreatedAt()->format('Y-m-d H:i:s'),
            ];
        } catch (\Exception $e) {
            $this->logger->error('Create task error!', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
    
    public function close(TaskForm $taskForm, $taskId): bool
    {
        try {
            $task = $this->_em->getRepository(Task::class)->find($taskId);
            if (!$task) {
                throw new ValidationException([], $taskId . ' id task not found!');
            }
            
            if ($task->getStatus() === Status::CLOSED) {
                throw new ValidationException([], $taskId . ' id task already closed!');
            }
            
            $task->setCloseDescription($taskForm->getCloseDescription());
            $task->setStatus($taskForm->getStatus());
            $task->setUpdatedAt(new \DateTime('now'));
            
            $this->_em->persist($task);
            $this->_em->flush();
            
            return true;
        } catch (\Exception $e) {
            $this->logger->error('Task close error!', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString()
            ]);
            
            throw $e;
        }
    }
}
