<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use beastbytes\wizard\WizardMenu;
use andahrm\leave\WizardMenu;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveRelated */

$this->title = Yii::t('andahrm/leave', 'Create Leave Related');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Relateds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-related-create">

                     
                      
                      
                      
                     
    <?php echo WizardMenu::widget([
      'currentStepCssClass' => 'selected',
      'step' => $event->step,
      'wizard' => $event->sender,
      'options' => ['class'=>'wizard_steps anchor']
    ]);?>

  
    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

   

   
  <?php
  echo Html::beginTag('div', ['class' => 'form-row buttons']);
echo Html::submitButton('Next', ['class' => 'button', 'name' => 'next', 'value' => 'next']);
echo Html::submitButton('Pause', ['class' => 'button', 'name' => 'pause', 'value' => 'pause']);
echo Html::submitButton('Cancel', ['class' => 'button', 'name' => 'cancel', 'value' => 'pause']);
echo Html::endTag('div');
  ?>
  
   <?php ActiveForm::end(); ?>
</div>
