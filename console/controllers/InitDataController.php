<?php

namespace console\controllers;

use console\components\DataHelper;
use frontend\models\olymp\Appearance;
use frontend\models\olymp\Application;
use frontend\models\olymp\Participant;
use frontend\models\olymp\School;
use frontend\models\olymp\Subject;
use frontend\models\olymp\SubjectCategory;
use frontend\models\olymp\Task;
use frontend\models\olymp\TaskApplication;
use phpseclib3\Crypt\Random;
use Yii;
use yii\console\Controller;

class InitDataController extends Controller
{
    public function actionInit(){
        $this->actionInitSchools();
        $this->actionInitSubjects();
        $this->actionInitSubjectCategory();
        $this->actionInitParticipant(300);
        $this->actionInitApplication(450);
        $this->actionInitResult();
    }
    public function actionInitSchools(){
        foreach (DataHelper::SCHOOLS as $school){
            $model = new School();
            $model->name = $school[0];
            $model->region = $school[1];
            $model->save();
        }
    }
    public function actionInitSubjects()
    {
        foreach (DataHelper::SUBJECTS as $subject){
            $model = new Subject();
            $model->name = $subject[0];
            $model->subject_code = $subject[1];
            $model->save();
        }
    }
    public function actionInitSubjectCategory()
    {
        $subjects = Subject::find()->all();
        foreach ($subjects as $subject){
            for($i = 9; $i <= 11; $i++){
                $model = new SubjectCategory();
                $model->subject_id = $subject->id;
                $model->category = $i;
                $model->prize_score = 30;
                $model->winner_score = 60;
                $model->save();
            }
        }
    }
    public function actionInitParticipant($count = 500){
        $schools = School::find()->all();
        $classes = [9, 10, 11];
        for($i = 0; $i < $count; $i++){
            $model = new Participant();
            $model->surname = DataHelper::SURNAMES[array_rand(DataHelper::SURNAMES)];
            $model->name = DataHelper::NAMES[array_rand(DataHelper::NAMES)];
            $model->patronymic = DataHelper::PATRONYMICS[array_rand(DataHelper::PATRONYMICS)];
            $model->phone_number = '+79896805424';
            $model->sex = 0;
            $model->birthdate = '2005-05-16';
            $model->citizenship = 1;
            $model->school_id = ($schools[array_rand($schools)])->id;
            $model->disability = 0;
            $model->class = $classes[array_rand([9, 10, 11])];
            if(!$model->save()){
                throw new \yii\web\ServerErrorHttpException(json_encode($model->getErrors()));
            }
        }
    }
    public function actionInitApplication($try = 700)
    {
        $participants = Participant::find()->all();
        $subjectCategories = SubjectCategory::find()->all();
        for($i = 0; $i < $try; $i++){
            $model = new Application();
            $model->subject_category_id = $subjectCategories[array_rand($subjectCategories)]->id;
            $model->participant_id = $participants[array_rand($participants)]->id;
            $model->code = 'CODE X';
            if (!Application::find()->where(['participant_id' => $model->participant_id])->andWhere(['subject_category_id' => $model->subject_category_id])->exists()){
                $model->save();
            }
        }
    }
    public function actionInitResult()
    {
        $this->actionInitTask();
        $this->actionInitAppearances();
        $this->actionInitPoints();
    }
    public function actionInitTask($count = 7)
    {
        $subjectCategories = SubjectCategory::find()->all();
        foreach ($subjectCategories as $subjectCategory) {
            for($i = 0; $i < $count; $i++){
                $model = new Task();
                $model->subject_category_id = $subjectCategory->id;
                $model->number = (string)($i + 1);
                $model->max_points = 20;
                if(!$model->save()){
                    throw new \yii\web\ServerErrorHttpException(json_encode($model->getErrors()));
                }
            }
        }
    }
    public function actionInitAppearances(){
        $applications = Application::find()->all();
        foreach ($applications as $application){
            $model = new Appearance();
            $model->status = array_rand([Appearance::NON_APPEARANCE, Appearance::APPEARANCE]);
            $model->application_id = $application->id;
            $model->auditorium = 'АУДИТОРИЯ';
            if(!$model->save()){
                throw new \yii\web\ServerErrorHttpException(json_encode($model->getErrors()));
            }
        }
    }
    public function actionInitPoints(){
        $subjectCategories = SubjectCategory::find()->all();
        foreach ($subjectCategories as $subjectCategory) {
            $applications = Application::find()->where(['subject_category_id' => $subjectCategory->id])->all();
            $tasks = Task::find()->where(['subject_category_id' => $subjectCategory->id])->all();
            foreach ($applications as $application){
                foreach ($application->appearances as $appearance){
                    if ($appearance->status == Appearance::APPEARANCE) {
                        foreach ($tasks as $task) {
                            $model = new TaskApplication();
                            $model->application_id = $application->id;
                            $model->task_id = $task->id;
                            $model->points = rand(0, $task->max_points);
                            if (!$model->save()) {
                                throw new \yii\web\ServerErrorHttpException(json_encode($model->getErrors()));
                            }
                        }
                    }
                }
            }
        }
    }
}