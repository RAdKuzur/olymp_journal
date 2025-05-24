<?php
/** @var yii\web\View $this */
/** @var $tasks */
/** @var $models */

use wbraganca\dynamicform\DynamicFormWidget;
use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Задания олимпиады';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-category-tasks">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= GridView::widget([
        'dataProvider' => new ArrayDataProvider([
            'allModels' => $tasks,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]),
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'number',
                'label' => 'Номер задания',
                'value' => 'number'
            ],
            [
                'attribute' => 'max_points',
                'label' => 'Макс. кол-во баллов',
                'value' => 'max_points'
            ],
            [
                'label' => 'Действия',
                'format' => 'raw',
                'value' => function ($model) {
                    return Html::a('Удалить', ['delete-task', 'id' => $model->id]);
                }
            ]
        ],
    ]);
    ?>
    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
        <div class="panel panel-default">
            <div class="panel-heading"><h4><i class="glyphicon glyphicon-envelope"></i> Задания </h4></div>
            <div class="panel-body">
                <?php DynamicFormWidget::begin([
                    'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                    'widgetBody' => '.container-items', // required: css class selector
                    'widgetItem' => '.item', // required: css class
                    'limit' => 50, // the maximum times, an element can be cloned (default 999)
                    'min' => 1, // 0 or 1 (default 1)
                    'insertButton' => '.add-item', // css class
                    'deleteButton' => '.remove-item', // css class
                    'model' => $models[0],
                    'formId' => 'dynamic-form',
                    'formFields' => [
                        'number',
                        'max_points'
                    ],
                ]); ?>
                <div class="container-items">
                    <?php foreach ($models as $i => $model): ?>
                        <div class="item panel panel-default">
                            <div class="panel-heading">
                                <div class="pull-right">
                                    <button type="button" class="add-item btn btn-success btn-xs"><i class="glyphicon glyphicon-plus"> + </i></button>
                                    <button type="button" class="remove-item btn btn-danger btn-xs"><i class="glyphicon glyphicon-minus"> - </i></button>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                            <div class="panel-body">
                                <?= $form->field($model, "[{$i}]number")->textInput(['maxlength' => true])->label('Номер задания') ?>
                                <?= $form->field($model, "[{$i}]max_points")->textInput(['maxlength' => true])->label('Максимальное количество баллов за задания') ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php DynamicFormWidget::end(); ?>
            </div>
        </div>
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    <?php ActiveForm::end(); ?>
</div>