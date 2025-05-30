<?php

namespace backend\controllers\admin;

use common\repositories\ApplicationRepository;
use common\repositories\ParticipantRepository;
use common\repositories\SubjectCategoryRepository;
use frontend\models\olymp\Application;
use Yii;
use yii\web\Controller;

class ApplicationController extends Controller
{
    private ApplicationRepository $applicationRepository;
    private SubjectCategoryRepository $subjectCategoryRepository;
    private ParticipantRepository $participantRepository;
    public function __construct(
        $id,
        $module,
        ApplicationRepository $applicationRepository,
        SubjectCategoryRepository $subjectCategoryRepository,
        ParticipantRepository $participantRepository,
        $config = []
    )
    {
        $this->applicationRepository = $applicationRepository;
        $this->subjectCategoryRepository = $subjectCategoryRepository;
        $this->participantRepository = $participantRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(){
        $applications = $this->applicationRepository->getAll();
        return $this->render('index', [
            'applications' => $applications
        ]);
    }
    public function actionCreate(){
        $model = new Application();
        $participants = $this->participantRepository->getAll();
        $subjectCategories = $this->subjectCategoryRepository->getAll();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $this->applicationRepository->save($model);
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
            'participants' => $participants,
            'subjectCategories' => $subjectCategories
        ]);
    }
    public function actionUpdate($id){
        $model = $this->applicationRepository->get($id);
        $participants = $this->participantRepository->getAll();
        $subjectCategories = $this->subjectCategoryRepository->getAll();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $this->applicationRepository->save($model);
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'participants' => $participants,
            'subjectCategories' => $subjectCategories
        ]);
    }
    public function actionDelete($id){
        $this->applicationRepository->delete($id);
        return $this->redirect(['index']);
    }
    public function beforeAction($action){
        if (!Yii::$app->request->cookies->has('usernameBack')){
            return $this->redirect('index.php?r=site/login');
        }
        return parent::beforeAction($action);
    }
}