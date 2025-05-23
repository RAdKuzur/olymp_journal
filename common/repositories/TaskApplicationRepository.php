<?php

namespace common\repositories;

use frontend\models\olymp\TaskApplication;
use yii\helpers\BaseArrayHelper;

class TaskApplicationRepository
{
    private TaskRepository $taskRepository;
    public function __construct(
        TaskRepository $taskRepository
    )
    {
        $this->taskRepository = $taskRepository;
    }
    public function getByTaskAndApplicationId($applicationId, $taskId)
    {
        return TaskApplication::find()
            ->where(['application_id' => $applicationId, 'task_id' => $taskId])
            ->one();
    }
    public function getBySubjectCategoryId($subjectCategoryId)
    {
        $tasks = $this->taskRepository->getBySubjectCategoryId($subjectCategoryId);
        return TaskApplication::find()->where(['IN',  'task_id', BaseArrayHelper::getColumn($tasks, 'id')])->all();
    }
    public function create($applicationId, $taskId, $points = 0)
    {
        $taskApplication = TaskApplication::fill($applicationId, $taskId, $points);
        $this->save($taskApplication);
    }
    public function checkUnique($applicationId, $taskId)
    {
        return TaskApplication::find()
            ->where(['task_id' => $taskId])
            ->andWhere(['application_id' => $applicationId])
            ->exists();
    }
    public function changeScore(TaskApplication $model, $points)
    {
        $model->points = $points;
    }
    public function save(TaskApplication $taskApplication){
        if(!$taskApplication->save()){
            throw new \RuntimeException('Saving error.');
        }
    }
    public function delete(TaskApplication $taskApplication){
        if(!$taskApplication->delete()){
            throw new \RuntimeException('Deleting error.');
        }
    }
}