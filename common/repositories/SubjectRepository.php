<?php

namespace common\repositories;

use frontend\models\olymp\Subject;

class SubjectRepository
{
    public function get($id){
        return Subject::findOne($id);
    }
    public function getAll(){
        return Subject::find()->all();
    }
    public function getByCode($code){
        return Subject::find()->where(['code'=>$code])->all();
    }
    public function save(Subject $subject){
        if(!$subject->save()){
            throw new \RuntimeException('Saving error.');
        }
    }
    public function delete(Subject $subject){
        if(!$subject->delete()){
            throw new \RuntimeException('Delete error.');
        }
    }
}