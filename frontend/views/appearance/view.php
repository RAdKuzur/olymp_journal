<?php
/** @var yii\web\View $this */
/** @var \frontend\models\olymp\Appearance $appearance */
/** @var $id */

use yii\data\ArrayDataProvider;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

$this->title = 'Явки';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="appearance-view">
    <?php
        if(count($appearance)) {
            echo GridView::widget([
                'dataProvider' => new ArrayDataProvider([
                    'allModels' => $appearance,
                    'pagination' => false,
                ]),
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'label' => 'ФИО участника',
                        'value' => function(\frontend\models\olymp\Appearance $model) {
                            return $model->application->participant->getFullFio();
                        }
                    ],
                    [
                        'attribute' => 'status',
                        'label' => 'Явка',
                        'format' => 'raw',
                        'value' => function($model) {
                            return Html::dropDownList(
                                'attendance['.$model->id.']',
                                $model->status,
                                [
                                    \frontend\models\olymp\Appearance::NON_APPEARANCE => 'Неявка',
                                    \frontend\models\olymp\Appearance::APPEARANCE => 'Явка'
                                ],
                                [
                                    'class' => 'form-control attendance-select',
                                    'data-id' => $model->id,
                                    'style' => $model->status == \frontend\models\olymp\Appearance::NON_APPEARANCE
                                        ? 'background-color: #ffcccc;'
                                        : 'background-color: #ccffcc;',
                                    'onchange' => 'this.style.backgroundColor = this.value == "' . \frontend\models\olymp\Appearance::NON_APPEARANCE . '" ? "#ffcccc" : "#ccffcc"'
                                ]
                            );
                        }
                    ]
                ]
            ]);
        }
        echo Html::a('Сформировать явки', ['create', 'id' => $id], ['class' => 'btn btn-success']);
    ?>
</div>
<?php
    $this->registerJs("
        $('.attendance-select').change(function() {
            var id = $(this).data('id');
            var status = $(this).val();
            $.post('". Url::to(['/appearance/update-status'])."', {
                id: id,
                status: status,
                _csrf: '".Yii::$app->request->getCsrfToken()."'
            })
            .fail(function() {
                alert('Ошибка сервера!');
            });
        });
    ");
?>