<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveInspactorSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'to') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'leave_type_id') ?>

    <?= $form->field($model, 'contact') ?>

    <?php // echo $form->field($model, 'date_start') ?>

    <?php // echo $form->field($model, 'start_part') ?>

    <?php // echo $form->field($model, 'date_end') ?>

    <?php // echo $form->field($model, 'end_part') ?>

    <?php // echo $form->field($model, 'reason') ?>

    <?php // echo $form->field($model, 'acting_user_id') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'inspector_comment') ?>

    <?php // echo $form->field($model, 'inspector_status') ?>

    <?php // echo $form->field($model, 'inspector_by') ?>

    <?php // echo $form->field($model, 'inspector_at') ?>

    <?php // echo $form->field($model, 'commander_comment') ?>

    <?php // echo $form->field($model, 'commander_status') ?>

    <?php // echo $form->field($model, 'commander_by') ?>

    <?php // echo $form->field($model, 'commanded_at') ?>

    <?php // echo $form->field($model, 'director_comment') ?>

    <?php // echo $form->field($model, 'director_status') ?>

    <?php // echo $form->field($model, 'director_by') ?>

    <?php // echo $form->field($model, 'director_at') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('andahrm', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
