<?php
/** @var yii\web\View $this */
/** @var frontend\models\olymp\SubjectCategory $model */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Просмотр олимпиады: ' . $model->subject->name;
$this->params['breadcrumbs'][] = ['label' => 'Список олимпиад', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-category-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту олимпиаду?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Вернуться к списку', ['index'], ['class' => 'btn btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'subject.name',
                'label' => 'Предмет',
            ],
            [
                'attribute' => 'category',
                'label' => 'Класс',
                'value' => function($model) {
                    return $model->category . ' класс';
                },
            ],
        ],
        'options' => ['class' => 'table table-striped table-bordered detail-view'],
    ]) ?>

</div>