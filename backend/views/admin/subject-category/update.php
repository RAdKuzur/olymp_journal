<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model */
/** @var $subjects */

$this->title = 'Редактировать ' . $model->subject->name . ' ' . $model->category . ' ' . ' класс';
$this->params['breadcrumbs'][] = 'Редактирование';
?>
<div class="subject-category-update">
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