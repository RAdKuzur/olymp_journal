<?php
/** @var yii\web\View $this */
/** @var $model */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->fullFio;
$this->params['breadcrumbs'][] = ['label' => 'Список участников', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="participant-view">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Перейти к списку', ['index'], ['class' => 'btn btn-default']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'fullFio',
                'label' => 'ФИО участника',
            ],
            [
                'attribute' => 'phone_number',
                'label' => 'Номер телефона',
            ],
            [
                'attribute' => 'gender',
                'label' => 'Пол',
            ],
            [
                'attribute' => 'birthdate',
                'label' => 'Дата рождения',
            ],
            [
                'attribute' => 'citizenship',
                'label' => 'Гражданство',
                'value' => function($model) {
                    return Yii::$app->countries->getList()[$model->citizenship];
                }
            ],
            [
                'attribute' => 'school_id',
                'label' => 'Муниципальное учреждение',
                'value' => function ($model) {
                    return $model->school->name;
                }
            ],
            [
                'attribute' => 'ovz',
                'label' => 'ОВЗ',
            ],
            [
                'attribute' => 'class',
                'label' => 'Класс обучение',
                'value' => function ($model) {
                    return $model->class . ' ' . 'класс';
                }
            ],
        ],
    ]) ?>

</div>