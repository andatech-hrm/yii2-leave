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
//$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
$personLeave = PersonPosition::findOne(Yii::$app->user->identity->id);
//echo $personLeave->position->section->id;
$personLeave = $personLeave->position->section->leaveRelatedSection;
// print_r($personLeave);
// exit();
//$items['user'] = $personLeave;

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
  
  
  /*$layout3 = <<< HTML
    <span class="input-group-addon">ตั้งแต่วันที่</span>
    {input1}
    <span class="input-group-addon">|</span>{$items['start_part']}
    <span class="input-group-addon">ถึงวันที่</span>
    {input2}
      <span class="input-group-addon">|</span>{$items['end_part']}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;
  
    
  $items['date_range']=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_RANGE,
    'options' => ['placeholder' => $model->getAttributeLabel('date_start')],
    'attribute2' => 'date_end',
    'options2' => ['placeholder' =>  $model->getAttributeLabel('date_end')],
     'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
    'layout' => $layout3,
    'pluginOptions' => [
        'autoclose'=>true,
        'datesDisabled' => LeaveDayOff::getList(),
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'todayBtn' => true,
        'startDate' => date('Y-m-d', strtotime("+1 day")),
        //'calendarWeeks' => true,
        'daysOfWeekDisabled' => [0, 6],
        
    ],
    'pluginEvents'=>[
        
    ]
    ])->label(false);
    
  $items['date_range'] .= $model->getFirstError('end_part');*/
  
  $datesDisabledGl = LeaveDayOff::getList();
  $datesDisabledTh = [];
  foreach ($datesDisabledGl as $date) {
      $datesDisabledTh[] = Yii::$app->formatter->asDate($date, 'php:d/m/Y');
  }
    $items['date_range'] = '<div class="row">';
    $items['date_range'] .= '<div class="col-sm-6">';
    $items['date_range'] .= $form->field($model, 'date_start', [
        'inputTemplate' => '{input}',
        'options' => [
            'style' => 'width: 80%; float:left'
        ]
    ])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => $datesDisabledTh]]);
    $items['date_range'] .= '<div style="width: 20%; float: left;"><label class="control-label">&nbsp;</label>' . $items['start_part'] . '</div>';
    $items['date_range'] .= '</div>';
    
    $items['date_range'] .= '<div class="col-sm-6">';
    $items['date_range'] .= $form->field($model, 'date_end', [
        'inputTemplate' => '{input}',
        'options' => [
            'style' => 'width: 80%; float:left'
        ]
    ])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => $datesDisabledTh]]);
    $items['date_range'] .= '<div style="width: 20%; float: left;"><label class="control-label">&nbsp;</label>' . $items['end_part'] . '</div>';
    $items['date_range'] .= '</div>';
    
    
    // $items['date_range'] .= $form->field($model, 'date_end', ['options' => ['class' => 'form-group col-sm-6']])->widget(DatePicker::className());
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


// $js = '<!--

// function ValidForm(){

// 	var PartIn = document.Absent.StartPart.value;
// 	var PartOut  = document.Absent.EndPart.value;
	
// 	var NumRest = document.Absent.NumRest.value;

// 	var gStartDate = document.Absent.StartDate.value;
// 	arrStartDate = gStartDate.split("/");
// 	StartDay = arrStartDate[0];
// 	StartMonth = arrStartDate[1];
// 	StartYear = arrStartDate[2];
// 	cmpStartDate = StartYear + StartMonth + StartDay;

// 	var gEndDate = document.Absent.EndDate.value;
// 	arrEndDate = gEndDate.split("/");
// 	EndDay = arrEndDate[0];
// 	EndMonth = arrEndDate[1];
// 	EndYear = arrEndDate[2];
// 	cmpEndDate = EndYear + EndMonth + EndDay;

// 	if(NumRest == ""){
// 		alert("ท่านยังไม่มีวันลาพักผ่อนสะสม ไม่สามารถลาพักผ่อนได้      \n\nกรุณาติดต่อเจ้าหน้าที่ระบบการลาหรือกจ. **ของหน่วยงานตนเอง** ");
// 		return false;
// 	}
// 	if(gStartDate == "" || gEndDate == ""){
// 		alert("กรุณาระบุวันลา !");
// 		return false;
// 	}
// 	if(cmpStartDate > cmpEndDate){
// 		alert("ระบุวันลาผิด กรุณาระบุใหม่ !");
// 		return false;
// 	}
// 	if((cmpStartDate == cmpEndDate) && (PartIn !== PartOut)){
// 		alert("ระบุวันลาผิด กรุณาระบุใหม่ !");
// 		return false;
// 	}
// 	if((cmpStartDate < cmpEndDate) && ((PartIn == "02") || (PartOut == "03"))){
// 		alert("ระบุวันลาผิด กรุณาระบุใหม่ !");
// 		return false;
// 	}
// 	if(document.Absent.AbsentSpecial.checked == 1){
// 			 if(document.getElementById("NumDay").value == "" || document.getElementById("NumDayAll").value == ""){
// 				alert("กรุณาระบุจำนวนวันลา  มีกำหนด?วัน เป็นวันทำการ?วัน");
// 				return false;
// 			}
// 	}

// 	// **********lock การลาข้ามปีงบประมาณ********************
	
	
// 	if(cmpStartDate > "25600930" || cmpEndDate > "25600930"){
// 		alert("ระบบยังไม่อนุญาตให้ทำใบลาของปีงบประมาณหน้า! \n\n เนื่องจากระบบต้องประมวลผลวันลา ณ สิ้นปีงบนี้ก่อน \n\n หากต้องการลา  กรุณาส่งใบลาด้วยกระดาษ");
// 		return false;
// 	}
// 	if(document.Absent.Header.value == "" || document.Absent.Permittee.value == ""){
// 		alert("กรุณาเลือกผู้มีอำนาจอนุมัติเอกสาร !");
// 		return false;
// 	}
// 	if(document.Absent.DeputyID.value == ""){
// 		if(confirm("ท่านไม่ได้เลือกผู้ปฎิบัติหน้าที่แทน ! ต้องการส่งเอกสารหรือไม่ ? ")){
// 			return true;
// 		}else{
// 			return false;
// 		}
// 	}
// 	return true;
// }
// //-->';
// $this->registerJs($js);

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