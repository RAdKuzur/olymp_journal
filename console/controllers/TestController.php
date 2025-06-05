<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;

class TestController extends Controller
{
    public function actionQueue(){
        Yii::$app->rabbitmq->publish('queue', 'test');
    }
}