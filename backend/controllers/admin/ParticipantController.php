<?php

namespace backend\controllers\admin;


use common\repositories\ParticipantRepository;
use common\repositories\SchoolRepository;
use frontend\models\olymp\Participant;
use Yii;
use yii\web\Controller;

class ParticipantController extends Controller
{
    public ParticipantRepository $participantRepository;
    public SchoolRepository $schoolRepository;
    public function __construct(
        $id,
        $module,
        ParticipantRepository $participantRepository,
        SchoolRepository $schoolRepository,
        $config = []
    )
    {
        $this->participantRepository = $participantRepository;
        $this->schoolRepository = $schoolRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionIndex(){
        $participants = $this->participantRepository->getAll();
        return $this->render('index', ['participants' => $participants]);
    }
    public function actionCreate(){
        $model = new Participant();
        $schools = $this->schoolRepository->getAll();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $this->participantRepository->save($model);
            return $this->redirect(['index']);
        }
        return $this->render('create', [
            'model' => $model,
            'schools' => $schools
        ]);
    }
    public function actionView($id){
        $model = $this->participantRepository->get($id);
        return $this->render('view', ['model' => $model]);
    }
    public function actionUpdate($id){
        $model = $this->participantRepository->get($id);
        $schools = $this->schoolRepository->getAll();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $this->participantRepository->save($model);
            return $this->redirect(['index']);
        }
        return $this->render('update', [
            'model' => $model,
            'schools' => $schools
        ]);
    }
    public function actionDelete($id){
        $model = $this->participantRepository->get($id);
        $this->participantRepository->delete($model);
        return $this->redirect(['index']);
    }
}