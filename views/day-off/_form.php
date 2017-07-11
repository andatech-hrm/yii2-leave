<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use andahrm\datepicker\DatePicker;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveDayOff */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-day-off-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_start')->widget(DatePicker::className()); ?>

    <?= $form->field($model, 'date_end')->widget(DatePicker::className()); ?>

    <?= $form->field($model, 'detail')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$inputStartId = Html::getInputId($model, 'date_start');
$inputEndId = Html::getInputId($model, 'date_end');
$js[] = <<< JS
$("#{$inputStartId}").datepicker().on('changeDate', function(e) { $("#{$inputEndId}").datepicker('setStartDate', $(this).val()); });
$("#{$inputEndId}").datepicker().on('changeDate', function(e) { $("#{$inputStartId}").datepicker('setEndDate', $(this).val()); });
JS;

$js = array_filter($js);
$this->registerJs(implode("\n", $js));