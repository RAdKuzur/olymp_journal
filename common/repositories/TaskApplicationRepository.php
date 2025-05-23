<?php

namespace common\repositories;

use frontend\models\olymp\TaskApplication;

class TaskApplicationRepository
{
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