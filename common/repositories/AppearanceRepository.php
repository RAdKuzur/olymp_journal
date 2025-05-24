<?php

namespace common\repositories;

use frontend\models\olymp\Appearance;

class AppearanceRepository
{
    public function get($id)
    {
        return Appearance::findOne($id);
    }
    public function getAll()
    {
        return Appearance::find()->all();
    }
    public function getBySubjectId($subjectCategoryId){
        return Appearance::find()
            ->joinWith('application')
            ->where(['application.subject_category_id' => $subjectCategoryId])
            ->all();
    }
    public function getByApplicationId($applicationId){
        return Appearance::find()->where(['application_id' => $applicationId])->all();
    }
    public function checkUnique($applicationId)
    {
        return Appearance::find()->where(["application_id" => $applicationId])->exists();
    }
    public function create($applicationId, $status, $auditorium){
       $model = Appearance::fill($applicationId, $status, $auditorium);
       $this->save($model);
    }
    public function save(Appearance $appearance){
        if(!$appearance->save()){
            throw new \RuntimeException('Saving error.');
        }
    }
    public function getAppearancesBySubjectCategoryId($subjectCategoryId)
    {
        return Appearance::find()
            ->joinWith('application')
            ->where(['application.subject_category_id' => $subjectCategoryId])
            ->andWhere(['appearance.status' => Appearance::APPEARANCE])
            ->all();
    }
}