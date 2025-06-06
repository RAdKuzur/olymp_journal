<?php

namespace backend\controllers\admin;

use common\components\AuthComponent;
use common\repositories\SubjectRepository;
use frontend\models\olymp\Subject;
use Yii;

class SubjectController extends \yii\web\Controller
{
    private SubjectRepository $subjectRepository;
    public function __construct(
        $id,
        $module,
        SubjectRepository $subjectRepository,
        $config = []
    )
    {
        $this->subjectRepository = $subjectRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(){
        $subjects = $this->subjectRepository->getAll();
        return $this->render('index', ['subjects' => $subjects]);
    }
    public function actionCreate(){
        $model = new Subject();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $this->subjectRepository->save($model);
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }
    public function actionUpdate($id){
        $model = $this->subjectRepository->get($id);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->subjectRepository->save($model);
            return $this->redirect(['index']);
        }
        return $this->render('create', ['model' => $model]);
    }
    public function actionDelete($id){
        $model = $this->subjectRepository->get($id);
        $this->subjectRepository->delete($model);
        return $this->redirect(['index']);
    }
    public function beforeAction($action){
        if (AuthComponent::isGuest()){
            return $this->redirect('index.php?r=site/login');
        }
        return parent::beforeAction($action);
    }
}