<?php

namespace common\repositories;

use frontend\models\olymp\Task;

class TaskRepository
{
    public function get($id){
        return Task::findOne($id);
    }
    public function getAll(){
        return Task::find()->all();
    }
    public function getBySubjectCategoryId($subjectCategoryId){
        return Task::find()->where(['subject_category_id' => $subjectCategoryId])->all();
    }
    public function checkUnique($subjectCategoryId, $number)
    {
        return Task::find()
            ->where(['subject_category_id' => $subjectCategoryId])
            ->andWhere(['number' => $number])
            ->exists();
    }
    public function create($subjectCategoryId, $number, $maxPoints){
        $task = Task::fill($subjectCategoryId, $number, $maxPoints);
        $this->save($task);
    }
    public function save(Task $task){
        if(!$task->save()){
            throw new \RuntimeException('Saving error.');
        }
    }
    public function delete(Task $task){
        if(!$task->delete()){
            throw new \RuntimeException('Delete error.');
        }
    }
}