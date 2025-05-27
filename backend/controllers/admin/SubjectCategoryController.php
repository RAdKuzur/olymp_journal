<?php

namespace backend\controllers\admin;

use common\repositories\SubjectCategoryRepository;
use common\repositories\SubjectRepository;
use frontend\models\olymp\SubjectCategory;
use Yii;

class SubjectCategoryController extends \yii\web\Controller
{
    private SubjectRepository $subjectRepository;
    private SubjectCategoryRepository $subjectCategoryRepository;
    public function __construct(
        $id,
        $module,
        SubjectRepository $subjectRepository,
        SubjectCategoryRepository $subjectCategoryRepository,
        $config = []
    )
    {
        $this->subjectRepository = $subjectRepository;
        $this->subjectCategoryRepository = $subjectCategoryRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(){
        $subjectCategories = $this->subjectCategoryRepository->getAll();
        return $this->render('index', ['subjectCategories' => $subjectCategories]);
    }
    public function actionCreate(){
        $model = new SubjectCategory();
        $subjects = $this->subjectRepository->getAll();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $this->subjectCategoryRepository->save($model);
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
            'subjects' => $subjects
        ]);
    }
    public function actionUpdate($id){
        $model = $this->subjectCategoryRepository->get($id);
        $subjects = $this->subjectRepository->getAll();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $this->subjectCategoryRepository->save($model);
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'subjects' => $subjects
        ]);
    }
    public function actionDelete($id){
        $model = $this->subjectCategoryRepository->get($id);
        $this->subjectCategoryRepository->delete($model);
        return $this->redirect(['index']);
    }
}