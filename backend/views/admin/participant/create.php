<?php


use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $model */
/** @var $schools */

$this->title = 'Создание участника';
$this->params['breadcrumbs'][] = 'Создание';
?>
<div class="participant-create">
    <div class="substrate">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <?= $this->render('_form',
        [
            'model' => $model,
            'schools' => $schools
        ]
    ) ?>
</div>