<?php
/** @var yii\web\View $this */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список предметов';
$this->params['breadcrumbs'][] = $this->title;
/* @var $subjects */
?>
<div class="subject-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Список предметов:</p>
    <?= Html::a('Добавить предмет', ['create'], ['class' => 'btn btn-success']); ?>
    <?=
    GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $subjects,
        ]),
        'columns' => [
            [
                'attribute' => 'name',
                'label' => 'Название предмета',
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
