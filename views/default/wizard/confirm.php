<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\LeaveDayOff;

use andahrm\leave\models\PersonLeave;
use andahrm\structure\models\FiscalYear;

use backend\widgets\WizardMenu;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Confirm Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Select Type'), 'url' => ['create','step'=>'select']];
$this->params['breadcrumbs'][] = $this->title;

//$modelSelect$modelSelect->leave_type_id;
//print_r($modelSelect);

$modelSelect = $event->sender->read('select')[0];
?>

<?php echo WizardMenu::widget([
      'currentStepCssClass' => 'selected',
      'step' => $event->step,
      'wizard' => $event->sender,
      'options' => ['class'=>'wizard_steps anchor']
    ]);?>

<div class="leave-form">
    <hr/>
    <?php $form = ActiveForm::begin(); 
    //$model->status = 1;
    echo $form->field($model, 'status')->hiddenInput()->label(false);
    
    
    if($modelSelect->leave_type_id==1){
         echo $this->render('_confirm-vacation',['form'=>$form,'model'=>$model,'event'=>$event]);
     }else{
         echo $this->render('_confirm-sick',['form'=>$form,'model'=>$model,'event'=>$event]);
     }
  
  
  ?>

     <?=$this->render('button',['event'=>$event]);?>
     
    <?php ActiveForm::end(); ?>

</div>

