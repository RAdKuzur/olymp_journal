<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model */
/* @var $subjects */
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <?= $form->field($model, 'category')->dropDownList(
        \common\components\Dictionary::getClasses()
    )->label('Возрастная категория (класс)'); ?>
    <?= $form->field($model, 'subject_id')->dropDownList(\yii\helpers\ArrayHelper::map($subjects, 'id', 'name'), ['prompt' => '---'])->label('Название предмета'); ?>
    <?= $form->field($model, 'prize_score')->textInput(['maxlength' => true])->label('Минимальное количество очков для призёра'); ?>
    <?= $form->field($model, 'winner_score')->textInput(['maxlength' => true])->label('Минимальное количество очков для победителя'); ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>