<?php

namespace frontend\controllers;

use common\repositories\AppearanceRepository;
use common\repositories\TaskApplicationRepository;
use common\services\AppearanceService;
use common\services\ErrorService;
use frontend\models\olymp\Appearance;
use Yii;

class AppearanceController extends \yii\web\Controller
{
    private AppearanceRepository $appearanceRepository;
    private AppearanceService $appearanceService;
    private ErrorService $errorService;
    private TaskApplicationRepository $taskApplicationRepository;

    public function __construct(
        $id,
        $module,
        AppearanceRepository $appearanceRepository,
        AppearanceService $appearanceService,
        ErrorService $errorService,
        TaskApplicationRepository $taskApplicationRepository,
        $config = []
    )
    {
        $this->appearanceRepository = $appearanceRepository;
        $this->appearanceService = $appearanceService;
        $this->errorService = $errorService;
        $this->taskApplicationRepository = $taskApplicationRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionView($id){
        $this->errorService->checkError($id, ErrorService::APPEARANCE_TYPE_ERROR);
        $appearance = $this->appearanceRepository->getBySubjectId($id);
        return $this->render('view',
        [
            'id' => $id,
            'appearance' => $appearance,
        ]);
    }

    public function actionCreate($id){
        $this->appearanceService->createAppearance($id);
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionUpdateStatus()
    {
        /* @var $model Appearance */
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $id = Yii::$app->request->post('id');
        $status = Yii::$app->request->post('status');
        $model = $this->appearanceRepository->get($id);
        if ($model) {
            $model->setStatus($status);
            if ($status == Appearance::NON_APPEARANCE){
                $tasks = $this->taskApplicationRepository->getByApplicationId($model->application_id);
                foreach ($tasks as $task){
                    $this->taskApplicationRepository->delete($task);
                }
            }
            return ['success' => $this->appearanceRepository->save($model)];
        }
        return ['success' => false];
    }
}