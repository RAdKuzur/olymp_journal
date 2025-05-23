<?php

namespace common\repositories;

use frontend\models\olymp\Application;

class ApplicationRepository
{
    public function get($id)
    {
        return Application::findOne($id);
    }
    public function getAll()
    {
        return Application::find()->all();
    }
    public function getByParticipantId($participantId){
        return Application::find()->where(['participant_id' => $participantId])->all();
    }
    public function getBySubjectCategoryId($subjectCategoryId){
        return Application::find()->where(['subject_category_id' => $subjectCategoryId])->all();
    }
    public function save(Application $application){
        if(!$application->save()){
            throw new \RuntimeException('Saving error.');
        }
    }
    public function delete(Application $application){
        if(!$application->delete()){
            throw new \RuntimeException('Delete error.');
        }
    }
}