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
}