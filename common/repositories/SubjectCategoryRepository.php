<?php
namespace common\repositories;




use frontend\models\olymp\SubjectCategory;

class SubjectCategoryRepository
{
    public function get($id)
    {
        return SubjectCategory::findOne($id);
    }
    public function getAll(){
        return SubjectCategory::find()->all();
    }
    public function getAllQuery(){
        return SubjectCategory::find()->with('subject');
    }
    public function save(SubjectCategory $subjectCategory){
        if(!$subjectCategory->save()){
            throw new \RuntimeException('Saving error.');
        }
    }
    public function delete(SubjectCategory $subjectCategory){
        if(!$subjectCategory->delete()){
        throw new \RuntimeException('Delete error.');
        }
    }
}