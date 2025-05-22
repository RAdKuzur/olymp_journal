<?php

namespace frontend\controllers;



use common\repositories\SubjectCategoryRepository;
use Yii;
use yii\data\ActiveDataProvider;

class SubjectCategoryController extends \yii\web\Controller
{
    private SubjectCategoryRepository $subjectCategoryRepository;
    public function __construct(
        $id,
        $module,
        SubjectCategoryRepository $subjectCategoryRepository,
        $config = []
    )
    {
        $this->subjectCategoryRepository = $subjectCategoryRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(){
        $subjectCategories = $this->subjectCategoryRepository->getAllQuery();
        return $this->render('index', [
                'subjectCategories' => new ActiveDataProvider([
                    'query' => $subjectCategories
                ])
            ]
        );
    }
    public function actionView($id){
        $model = $this->subjectCategoryRepository->get($id);
        return $this->render('view', [
            'model' => $model
        ]);
    }
    public function actionCreate(){}
    public function actionUpdate($id){
        Yii::$app->session->setFlash('danger', 'Для изменения обратитесь к разработчику');
        return $this->redirect(['index']);
    }
    public function actionDelete($id){
        Yii::$app->session->setFlash('danger', 'Для удаления обратитесь к разработчику');
        return $this->redirect(['index']);
    }
}