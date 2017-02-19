<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use andahrm\person\models\Person;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveRelated */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-related-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
  
  <div class="x_panel tile">
            <div class="x_title">
                <h2>เลือกผู้เกี่ยวข้อง</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

              <?= $form->field($model, 'inspector_by')->dropdownList(Person::getList(),['prompt'=>'เลือก']) ?>

              <?= $form->field($model, 'commander_by')->dropdownList(Person::getList(),['prompt'=>'เลือก']) ?>

              <?= $form->field($model, 'director_by')->dropdownList(Person::getList(),['prompt'=>'เลือก']) ?>
              
              <div class="clearfix"></div>
            </div>
        </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
