<?php

namespace console\controllers;

use common\services\RabbitMQService;
use Yii;
use yii\console\Controller;

class TestController extends Controller
{
    private RabbitMQService $rabbitMQService;
    public function __construct(
        $id,
        $module,
        RabbitMQService $rabbitMQService,
        $config = []
    )
    {
        $this->rabbitMQService = $rabbitMQService;
        parent::__construct(
            $id,
            $module,
            $config
        );
    }

    public function actionQueue(){
        for($i = 0; $i <= 10; $i++){
            $this->rabbitMQService->publish('resultService', 'appName', 'create', 'tableName', [
                'data' => 'who knows?',
                'item' => 312
            ]);
        }
    }
    public function actionTest(){
        var_dump($this->rabbitMQService->consume('resultService'));
    }
}