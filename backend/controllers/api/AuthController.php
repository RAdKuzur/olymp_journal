<?php

namespace backend\controllers\api;

use backend\services\ApiService;
use common\repositories\ApplicationRepository;
use Yii;
use yii\web\Controller;

class AuthController extends Controller
{
    private ApplicationRepository $applicationRepository;
    public function __construct(
        $id,
        $module,
        ApplicationRepository $applicationRepository,
        $config = []
    )
    {
        $this->applicationRepository = $applicationRepository;
        parent::__construct($id, $module, $config);
    }

    public function actionTest(){
        return Yii::$app->apiService->answer(['hello. api']);
    }

    public function actionTotalScore(){
        $participantId = Yii::$app->request->get('participantId');
        $subjectCategoryId = Yii::$app->request->get('eventId');
        $application = $this->applicationRepository->getApplication($participantId, $subjectCategoryId);
        return Yii::$app->apiService->answer([
            'participant' => $participantId,
            'eventId' => $subjectCategoryId,
            'score' => $application->getTotalScore()
        ]);
    }
}