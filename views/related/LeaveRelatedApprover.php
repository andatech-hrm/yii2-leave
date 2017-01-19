<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\leave\WizardMenu;

use softark\duallistbox\DualListbox;
use andahrm\person\models\Person;
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
  
  
  <?php
//   echo "<pre>";
//   print_r($event->data);
//   echo "</pre>";
  ?>
  <?php
  
    $options = [
        'multiple' => true,
        'size' => 20,
    ];
  
    $model->inspector_by = $model->inspectorBySelected;
    echo $form->field($model, 'inspector')->widget(DualListbox::className(),[
        'items' => Person::getList(),
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Items',
            'nonSelectedListLabel' => 'Available Items',
        ],
    ]);
    
?>
  
  
  <?php
  echo Html::beginTag('div', ['class' => 'form-row buttons']);
echo Html::submitButton('Next', ['class' => 'button', 'name' => 'next', 'value' => 'next']);
echo Html::submitButton('Pause', ['class' => 'button', 'name' => 'pause', 'value' => 'pause']);
echo Html::submitButton('Cancel', ['class' => 'button', 'name' => 'cancel', 'value' => 'pause']);
echo Html::endTag('div');
  ?>
  
   <?php ActiveForm::end(); ?>

</div>
