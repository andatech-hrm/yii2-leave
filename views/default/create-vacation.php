<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
// use kartik\widgets\DatePicker;
use kuakling\datepicker\DatePicker;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveDayOff;

use andahrm\leave\models\PersonLeave;
use andahrm\structure\models\FiscalYear;
use andahrm\positionSalary\models\PersonPosition;
use kartik\widgets\Select2;
use yii\web\JsExpression;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Create Leave Vacation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

# Candidate
$items=[];
$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
//$personLeave = PersonPosition::findOne(Yii::$app->user->identity->id);
//echo $personLeave->position->section->id;

// print_r($personLeave);
// exit();
$items['user'] = $personLeave;

$personLeave = $personLeave->position->section->leaveRelatedSection;

if($model->isNewRecord){
  $model->to = $personLeave->toDirector;
}
?>

<div class="leave-form">
<?='ปีงบประมาณ '.FiscalYear::currentYear()?>
 <?php $form = ActiveForm::begin();
  
  $items['created_at']=$model->isNewRecord ?'วันที่ '.Yii::$app->formatter->asDate('now','d').' เดือน '.Yii::$app->formatter->asDate('now','MMMM').' พ.ศ '.Yii::$app->formatter->asDate('now','yyyy'):'วันที่ '.Yii::$app->formatter->asDate($model->created_at,'d').' เดือน '.Yii::$app->formatter->asDate($model->created_at,'MMMM').' พ.ศ. '.Yii::$app->formatter->asDate($model->created_at,'yyyy'); 
  
  $items['user_id']=$form->field($model, 'user_id')->textInput(); 
  
  $items['to']=$form->field($model, 'to')->textInput(['placeholder'=>'เรียน']);
  
  $items['leave_type_id']=$form->field($model, 'leave_type_id')->textInput();
  
  #จำนวนวันที่ลาครั้งนี้
  $items['number_day']=$model->number_day?$model->number_day:0;
  
  $items['collect']=Leave::getCollect();
  
  $items['total']=$items['collect']+$items['user']->leavePermission->number_day;
    
   $items['start_part']=$form->field($model, 'start_part')->dropdownList(Leave::getItemStartPart())->label(false)->error(false)->hint(false);

   $items['end_part']=$form->field($model, 'end_part')->dropdownList(Leave::getItemEndPart())->label(false)->hint(false)->error(false);
  
  
    $items['date_range'] = '<div class="row">';
    $items['date_range'] .= '<div class="col-sm-6">';
    $items['date_range'] .= $form->field($model, 'date_start', [
        'inputTemplate' => '{input}',
        'options' => [
            'style' => 'width: 80%; float:left'
        ]
    ])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => LeaveDayOff::getList()]]);
    $items['date_range'] .= '<div style="width: 20%; float: left;"><label class="control-label">&nbsp;</label>' . $items['start_part'] . '</div>';
    $items['date_range'] .= '</div>';
    
    $items['date_range'] .= '<div class="col-sm-6">';
    $items['date_range'] .= $form->field($model, 'date_end', [
        'inputTemplate' => '{input}',
        'options' => [
            'style' => 'width: 80%; float:left'
        ]
    ])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => LeaveDayOff::getList()]]);
    $items['date_range'] .= '<div style="width: 20%; float: left;"><label class="control-label">&nbsp;</label>' . $items['end_part'] . '</div>';
    $items['date_range'] .= '</div>';
    $items['date_range'] .= '</div>';
  
    $items['contact']=$form->field($model, 'contact')->textInput(['placeholder'=>'ติดต่อข้าพเจ้าได้ที่']);
  
      $items['pastDay']=Leave::getPastDay();

    $items['reason']=$form->field($model, 'reason')->textarea(['rows' => 6]);
  
    //$items['status']=$form->field($model, 'status')->hiddenInput()->label(false)->hint(false);

     $items['acting_user_id'] = $form->field($model, 'acting_user_id')->widget(Select2::classname(), [
        //'initValueText' => $cityDesc, // set the initial display text
        'options' => ['placeholder' => 'ค้นหาบุคคล'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumInputLength' => 2,
            'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],
            'ajax' => [
                'url' => Url::to(['person-list']),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
         ],
    ]);
     
     
     //->dropdownList(Leave::getActingList(),['prompt'=>'เลือกผู้ปฎิบัติราชการแทน']);
  
      $items['acting_user'] = '(...........................................................)'; 
  
       
  $items['inspector_status'] = Leave::getWidgetStatus($model->inspector_status,Leave::getItemInspactorStatus());
  $items['inspectors'] = $form->field($model, 'inspector_by')->dropdownList($personLeave->inspectors,['prompt'=>'เลือกผู้ตรวจสอบ']);
   $items['inspector_comment'] = $model->inspector_comment?$model->inspector_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
   $items['inspector_at'] = $model->inspector_at?$model->inspectorAt:'วันที่............./............................/................ ' ;


    $items['commanders'] = $form->field($model, 'commander_by')->dropdownList($personLeave->commanders,['prompt'=>'เลือกผู้บังคับบัญชา']);
    $items['commander_status'] = Leave::getWidgetStatus($model->commander_status,Leave::getItemCommanderStatus());
    $items['commander_comment'] = $model->commander_comment?$model->commander_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
   $items['commander_at'] = $model->commander_at?$model->commanderAt:'วันที่............./............................/................ ' ; 
  
  
  $items['director_status'] = Leave::getWidgetStatus($model->director_status,Leave::getItemDirectorStatus());
    $items['directors'] = $form->field($model, 'director_by')->dropdownList($personLeave->directors,['prompt'=>'เลือกผู้ออกคำสั่ง']);
   $items['director_comment'] = $model->director_comment?$model->director_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
   $items['director_at'] = $model->director_at?$model->directorAt:'วันที่............./............................/................ ' ; 

  
?>
 
<?php 
  if($model->hasErrors()):?>
    <div class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong>คำเดือน</strong> <?=$model->getAttributeLabel('end_part').":".$model->getFirstError('end_part')?>
    </div>
  <?php  endif;?>

    <?=$this->render('template-vacation',$items)?>
  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php


$inputStartId = Html::getInputId($model, 'date_start');
$inputEndId = Html::getInputId($model, 'date_end');
$dateNow = Yii::$app->formatter->asDate('NOW()');
// $datesDisabled = \yii\helpers\Json::encode($datesDisabledGl);
$js[] = <<< JS
$("#{$inputStartId}").datepicker('setEndDate', "{$dateNow}");
// $("#{$inputEndId}").datepicker('setStartDate', $(this).val());

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