<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\structure\models\FiscalYear;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true ]
    ]); ?>
  
  
<div class="row">
  <div class="col-sm-3">
    <?= $form->field($model, 'year')->dropDownList(FiscalYear::getList(),[]) ?>
  </div>
  <div class="col-sm-3">
    <div class="form-group">
      <?= Html::submitButton(Yii::t('andahrm/leave', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('andahrm/leave', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>
  </div>

</div>

    <?php // echo $form->field($model, 'user_id') ?>

    <?php // echo $form->field($model, 'leave_type_id') ?>

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

    

    <?php ActiveForm::end(); ?>

</div>
