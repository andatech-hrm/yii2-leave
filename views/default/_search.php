<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'leave_type_id') ?>

    <?= $form->field($model, 'date_start') ?>

    <?= $form->field($model, 'start_part') ?>

    <?php // echo $form->field($model, 'date_end') ?>

    <?php // echo $form->field($model, 'end_part') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm/leave', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('andahrm/leave', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
