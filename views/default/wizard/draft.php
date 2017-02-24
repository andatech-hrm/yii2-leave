<?php
use yii\helpers\Html;
//use yii\widgets\ActiveForm;

use yii\bootstrap\ActiveForm;
use backend\widgets\WizardMenu;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Draft Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Select Type'), 'url' => ['create','step'=>'select']];
$this->params['breadcrumbs'][] = $this->title;




$modelSelect = $event->sender->read('select')[0];
//$modelSelect$modelSelect->leave_type_id;
//print_r($modelSelect);
?>

<?php echo WizardMenu::widget([
      'currentStepCssClass' => 'selected',
      'step' => $event->step,
      'wizard' => $event->sender,
      'options' => ['class'=>'wizard_steps anchor']
    ]);?>

<div class="row">
    <div class="col-sm-12">
       
        <?php $form = ActiveForm::begin(); ?>
       
       <div class="x_panel">
            <div class="x_title">
               <?=Html::tag('h2',$this->title.$modelSelect->leaveType->title)?>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php
                    
                     $model->leave_type_id = $modelSelect->leave_type_id;
                     if($modelSelect->leave_type_id==1){
                         echo $this->render('_form-vacation',['form'=>$form,'model'=>$model,'event'=>$event]);
                     }else{
                         echo $this->render('_form-sick',['form'=>$form,'model'=>$model,'event'=>$event]);
                     }
                ?>
                
                 
                  <?=$this->render('button',['event'=>$event]);?>
                  
                   <div class="clearfix"></div>
           </div>
       </div>
       
    
        
         
        <?php ActiveForm::end(); ?>
    
    </div>
</div>


<?php


$inputStartId = Html::getInputId($model, 'date_start');
$inputEndId = Html::getInputId($model, 'date_end');
// $datesDisabled = \yii\helpers\Json::encode($datesDisabledGl);
$js[] = <<< JS
$("#{$inputStartId}").datepicker().on('changeDate', function(e) { $("#{$inputEndId}").datepicker('setStartDate', $(this).val()); });
$("#{$inputEndId}").datepicker().on('changeDate', function(e) { $("#{$inputStartId}").datepicker('setEndDate', $(this).val()); });
JS;

$inputStartPartId = Html::getInputId($model, 'start_part');
$inputEndPartId = Html::getInputId($model, 'end_part');
$js[] = <<< JS
$(document).on('submit', "#{$form->id}", function(e){
    var inpStart = $("#{$inputStartId}");
    var inpEnd = $("#{$inputEndId}");
    var inpStartPart = $("#{$inputStartPartId}");
    var inpEndPart = $("#{$inputEndPartId}");
    
    var pass = true;
    if(inpStart.val() === inpEnd.val()){
        if(inpStartPart.val() !== inpEndPart.val()){
            pass = false;
            alert('การกำหนดวันลาไม่ถูกต้อง กรุณณากำหนดวันลาใหม่');
        }
    }
    
    return pass;
});
JS;

$js = array_filter($js);
$this->registerJs(implode("\n", $js));
?>
