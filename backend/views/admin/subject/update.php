<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model */

$this->title = 'Редактировать ' . $model->name;
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="subject-update">
    <div class="substrate">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <?= $this->render('_form',
        [
            'model' => $model
        ]
    ) ?>
</div>