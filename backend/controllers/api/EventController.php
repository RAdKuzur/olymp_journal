<?php

namespace backend\controllers\api;

use common\components\ApiHelper;
use Yii;
use yii\web\Controller;

class EventController extends Controller
{
    public function actionIndex(){
        $response = Yii::$app->apiService->get(ApiHelper::EVENT_UPL_API, [], ['Authorization' => 'Bearer' . ' ' . Yii::$app->request->cookies->getValue('usernameBack')['token']]);
        var_dump($response);
        var_dump('Bearer' . ' ' . Yii::$app->request->cookies->getValue('usernameBack')['token']);
        var_dump($response);
    }
}