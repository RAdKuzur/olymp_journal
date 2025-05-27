<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model */
/** @var $subjects */

$this->title = 'Создание олимпиады';
$this->params['breadcrumbs'][] = 'Создание';
?>
    <div class="subject-category-create">
    <div class="substrate">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
        <?= $this->render('_form',
            [
                'model' => $model,
                'subjects' => $subjects,
            ]
        ) ?>
    </div>
