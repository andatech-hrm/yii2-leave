<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use andahrm\leave\models\LeaveRelated;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveRelatedPerson */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-related-person-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'leave_related_id')->textInput() ?>
  
  
  
  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
