<?php
/** @var yii\web\View $this */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список участников';
$this->params['breadcrumbs'][] = $this->title;
/* @var $participants */
?>
<div class="participant-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Список участников:</p>
    <?= Html::a('Добавить участника', ['create'], ['class' => 'btn btn-success']); ?>
    <?=
    GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $participants,
        ]),
        'columns' => [
            [
                'attribute' => 'fullFio',
                'label' => 'ФИО участника',
            ],
            [
                'attribute' => 'phone_number',
                'label' => 'Номер телефона',
            ],
            [
                'attribute' => 'sex',
                'label' => 'Пол',
            ],
            [
                'attribute' => 'birthdate',
                'label' => 'Дата рождения',
            ],
            [
                'attribute' => 'citizenship',
                'label' => 'Гражданство',
            ],
            [
                'attribute' => 'school_id',
                'label' => 'Муниципальное учреждение',
                'value' => function ($model) {
                    return $model->school->name;
                }
            ],
            [
                'attribute' => 'disability',
                'label' => 'ОВЗ',
            ],
            [
                'attribute' => 'class',
                'label' => 'Класс обучение',
                'value' => function ($model) {
                    return $model->class . ' ' . 'класс';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model, $key) {
                        return Html::a('Просмотр', ['view' , 'id' => $model->id], ['class' => 'btn btn-warning']);
                    },

                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}',
                'buttons' => [
                    'update' => function ($url, $model, $key) {
                        return Html::a('Изменить', ['update' , 'id' => $model->id], ['class' => 'btn btn-info']);
                    }
                ],
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model, $key) {
                        return Html::a('Удалить', ['delete' , 'id' => $model->id], ['class' => 'btn btn-danger']);
                    },

                ],
            ],


        ],
    ]);
    ?>
</div>

