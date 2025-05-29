<?php
/** @var yii\web\View $this */

use frontend\models\olymp\Application;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список заявок';
$this->params['breadcrumbs'][] = $this->title;
/* @var $applications */
?>
<div class="subject-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Список заявок:</p>
    <?= Html::a('Добавить заявку', ['create'], ['class' => 'btn btn-success']); ?>
    <?=
    GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $applications,
        ]),
        'columns' => [
            [
                'label' => 'Название олимпиады',
                'value' => function(Application $model) {
                    return $model->subjectCategory->subject->name . ' ' . $model->subjectCategory->category . ' ' . 'класс';
                }
            ],
            [
                'label' => 'ФИО',
                'value' => function(Application $model) {
                    return $model->participant->getFullFio();
                }
            ],
            [
                'label' => 'Код участника',
                'attribute' => 'code'
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
