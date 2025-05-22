<?php

/** @var yii\web\View $this */

use yii\grid\GridView;
use yii\helpers\Html;

$this->title = 'Список олимпиад';
$this->params['breadcrumbs'][] = $this->title;
/* @var $subjectCategories */
?>
<div class="subject-category-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Список олимпиад:</p>
    <?=
        GridView::widget([
            'dataProvider' => $subjectCategories,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'subject.name',
                    'label' => 'Название предмета',
                    'value' => 'subject.name'
                ],
                [
                    'attribute' => 'category',
                    'label' => 'Возрастная группа',
                    'value' => function (\frontend\models\olymp\SubjectCategory $model) {
                        return $model->category . ' ' . 'класс';
                    }
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                ],
            ],
        ]);
    ?>
</div>
