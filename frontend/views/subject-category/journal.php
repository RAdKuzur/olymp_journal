<?php

/** @var yii\web\View $this */
/** @var $tasks */
/** @var $dataProvider */
/** @var $id */


use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Баллы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subject-category-journal">
    <?= Html::a('Сформировать баллы', ['create-journal', 'id' => $id], ['class' => 'btn btn-success']); ?>
    <?php
    $columns = [
        [
            'attribute' => 'application_id',
            'label' => 'ФИО',
            'value' => function($model) {
                return $model['application']->participant->getFullFio();
            }
        ],
        [
            'label' => 'Код участника',
            'value' => function($model) {
                return $model['application']->code;
            }
        ]
    ];

    foreach ($tasks as $taskId => $task) {
        $columns[] = [
            'attribute' => 'task_' . $taskId,
            'label' => $task->number,
            'format' => 'raw',
            'value' => function($model) use ($task, $taskId, $id) {
                $value = isset($model['task_' . $taskId]) ? $model['task_' . $taskId] : '';
                $appId = $model['application_id'];
                return Html::dropDownList(
                    "points[$appId][$taskId]",
                    $value,
                    array_merge(
                        array_combine(
                            range(0, $task->max_points), // Ключи от 0 до max_points
                            range(0, $task->max_points)  // Значения от 0 до max_points
                        )
                    ),
                    [
                        'class' => 'form-control points-dropdown',
                        'data-application-id' => $appId,
                        'data-task-id' => $taskId,
                        'data-url' => Url::to(['update-points', 'id' => $id]),
                    ]
                );
            }
        ];
    }

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $columns,
    ]);
    ?>
</div>
<?php
$this->registerJs(<<<JS
    $(document).on('change', '.points-dropdown', function() {
        var dropdown = $(this);
        var applicationId = dropdown.data('application-id');
        var taskId = dropdown.data('task-id');
        var points = dropdown.val();
        var url = dropdown.data('url');
        
        $.post(url, {
            application_id: applicationId,
            task_id: taskId,
            points: points
        }).done(function(response) {
            if (response.success) {
                // Можно показать уведомление об успешном сохранении
                toastr.success('Баллы успешно обновлены');
            } else {
                toastr.error('Ошибка при сохранении');
                // Восстанавливаем предыдущее значение при ошибке
                dropdown.val(response.previousValue || '');
            }
        }).fail(function() {
            toastr.error('Ошибка соединения');
            dropdown.val(dropdown.data('previous-value'));
        });
    });
    JS
);
?>