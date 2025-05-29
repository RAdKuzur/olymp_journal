<?php use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $model */
/* @var $participants */
/* @var $subjectCategories */
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <?= $form->field($model, 'subject_category_id')->dropDownList(\yii\helpers\ArrayHelper::map($subjectCategories, 'id', 'fullEventName'))->label('Название предмета (олимпиады)'); ?>
    <?= $form->field($model, 'participant_id')->dropDownList(\yii\helpers\ArrayHelper::map($participants, 'id', 'fullFio'))->label('ФИО участника'); ?>
    <?= $form->field($model, 'code')->textInput(['maxlength' => true])->label('Код участника'); ?>
    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>