<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model */
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Название предмета'); ?>
    <?= $form->field($model, 'subject_code')->textInput(['maxlength' => true])->label('Код предмета (на английском языке)'); ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>