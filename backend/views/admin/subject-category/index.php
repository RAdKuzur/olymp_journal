<?php
/** @var yii\web\View $this */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список олимпиад';
$this->params['breadcrumbs'][] = $this->title;
/* @var $subjectCategories */
?>
    <div class="subject-category-index">
        <h1><?= Html::encode($this->title) ?></h1>
        <p>Список предметов:</p>
        <?= Html::a('Добавить олимпиаду', ['create'], ['class' => 'btn btn-success']); ?>
        <?=
        GridView::widget([
            'dataProvider' => new ArrayDataProvider([
                'allModels' => $subjectCategories,
            ]),
            'columns' => [
                [
                    'attribute' => 'name',
                    'label' => 'Название предмета',
                    'value' => function (\frontend\models\olymp\SubjectCategory $model) {
                        return $model->subject->name;
                    }
                ],
                [
                    'label' => 'Возрастная категория',
                    'value' => function (\frontend\models\olymp\SubjectCategory $model) {
                        return $model->category;
                    }
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
<?php
