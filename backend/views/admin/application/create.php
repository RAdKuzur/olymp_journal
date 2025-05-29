<?php

use yii\helpers\Html;
/* @var $model */
/* @var $participants */
/* @var $subjectCategories */
$this->title = 'Создание заявки';
$this->params['breadcrumbs'][] = 'Создание';
?>
<div class="application-create">
    <div class="substrate">
        <h3><?= Html::encode($this->title) ?></h3>
    </div>
    <?= $this->render('_form',
        [
            'model' => $model,
            'participants' => $participants,
            'subjectCategories' => $subjectCategories
        ]
    ) ?>
</div>