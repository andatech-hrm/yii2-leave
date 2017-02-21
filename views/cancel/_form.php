<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveCancel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-cancel-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'to')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'leave_id')->textInput() ?>

    <?= $form->field($model, 'reason')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'date_start')->textInput() ?>

    <?= $form->field($model, 'start_part')->textInput() ?>

    <?= $form->field($model, 'date_end')->textInput() ?>

    <?= $form->field($model, 'end_part')->textInput() ?>

    <?= $form->field($model, 'number_day')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'commander_comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'commander_status')->textInput() ?>

    <?= $form->field($model, 'commander_by')->textInput() ?>

    <?= $form->field($model, 'commander_at')->textInput() ?>

    <?= $form->field($model, 'director_comment')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'director_status')->textInput() ?>

    <?= $form->field($model, 'director_by')->textInput() ?>

    <?= $form->field($model, 'director_at')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'created_by')->textInput() ?>

    <?= $form->field($model, 'updated_at')->textInput() ?>

    <?= $form->field($model, 'updated_by')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm/leave', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
