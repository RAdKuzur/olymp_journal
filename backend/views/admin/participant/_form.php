<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\jui\DatePicker;

/** @var $model */
/** @var $schools */
?>

<?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
<?= $form->field($model, 'surname')->textInput(['maxlength' => true])->label('Фамилия'); ?>
<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label('Имя'); ?>
<?= $form->field($model, 'patronymic')->textInput(['maxlength' => true])->label('Отчество'); ?>

<?= $form->field($model, 'phone_number')->widget(\yii\widgets\MaskedInput::className(), [
    'mask' => '+7 (999) 999-99-99',
])->label('Телефон'); ?>

<?= $form->field($model, 'sex')->dropDownList(
    Yii::$app->genders->getList()
)->label('Пол'); ?>

<?= $form->field($model, 'birthdate')->widget(DatePicker::class, [
    'language' => 'ru',
    'dateFormat' => 'yyyy-MM-dd',
    'options' => ['class' => 'form-control'],
    'clientOptions' => [
        'changeYear' => true,
        'changeMonth' => true,
        'yearRange' => '1900:' . date('Y'),
    ]
])->label('Дата рождения'); ?>

<?= $form->field($model, 'citizenship')->dropDownList(
    Yii::$app->countries->getList()
)->label('Гражданство'); ?>
<?= $form->field($model, 'school_id')->dropDownList(
    \yii\helpers\ArrayHelper::map($schools, 'id', 'name'),
    ['prompt' => 'Выберите школу']
)->label('Школа'); ?>

<?= $form->field($model, 'disability')->dropDownList(
    Yii::$app->disability->getList()
)->label('ОВЗ'); ?>

<?= $form->field($model, 'class')->dropDownList(
    Yii::$app->classes->getList()
)->label('Класс обучения'); ?>

<?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>