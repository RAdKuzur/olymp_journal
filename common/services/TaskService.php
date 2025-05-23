<?php

namespace common\services;

use common\repositories\TaskApplicationRepository;
use common\repositories\TaskRepository;

class TaskService
{
    private TaskRepository $taskRepository;
    private TaskApplicationRepository $taskApplicationRepository;
    public function __construct(
        TaskRepository $taskRepository,
        TaskApplicationRepository $taskApplicationRepository
    )
    {
        $this->taskRepository = $taskRepository;
        $this->taskApplicationRepository = $taskApplicationRepository;
    }

    public function createTasks($data, $subjectCategoryId)
    {
        foreach ($data as $task) {
            if(!$this->taskRepository->checkUnique($subjectCategoryId, $task['number'])){
                $this->taskRepository->create($subjectCategoryId, $task['number'], $task['max_points']);
            }
        }
    }
    public function delete($taskId)
    {
        $task = $this->taskRepository->get($taskId);
        foreach($task->taskApplications as $taskApplication){
            $this->taskApplicationRepository->delete($taskApplication);
        }
        $this->taskRepository->delete($task);
    }
}