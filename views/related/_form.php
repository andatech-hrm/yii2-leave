<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveRelated */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-related-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
  
  <div class="x_panel tile">
            <div class="x_title">
                <h2>ผู้มีอำนาจอนุมัติ</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <?=$this->render('_formApprove',[
                                'form'=>$form,
                                'model'=>$model,
                                              ])?>
          <div class="clearfix"></div>
        </div>
    </div>
          
              
              
              
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/leave', 'Create') : Yii::t('andahrm/leave', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
