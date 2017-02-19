<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use andahrm\structure\models\Section;
use andahrm\leave\models\LeaveRelatedSection;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveRelated */
/* @var $form yii\widgets\ActiveForm */

$modelSection->section_id = LeaveRelatedSection::getSectionSelected($model->id);

//print_r(LeaveRelatedSection::getSectionSelectedOther($model->id));

?>

<div class="leave-related-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <?= $form->field($modelSection, 'section_id')->widget(Select2::classname(), [
            'data' => Section::getList(),
            'options' => [
                'placeholder' => 'Select a state ...',
                'multiple' => true,
                'options' => LeaveRelatedSection::getSectionSelectedOther($model->id)
            
            ],
            'pluginOptions' => [
                'allowClear' => true
            ],
        ]); ?>
  
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
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
