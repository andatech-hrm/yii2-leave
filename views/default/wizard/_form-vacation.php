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


# Candidate
    $items=[];
    $personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
    $items['user'] = $personLeave;
    $personLeave = $personLeave->position->section->leaveRelatedSection;
    if($model->isNewRecord){
      $model->to = $personLeave->toDirector;
    }
    

    echo 'ปีงบประมาณ '.FiscalYear::currentYear();
?>

<div class="leave-form">

    <div class="row">
        <div class="col-sm-4">
        <?=$form->field($model, 'to')->textInput(['placeholder'=>'เรียน']);?>
        </div>
    </div>
    
  
  <hr/>
<?=Html::tag('h4','มีความประสงค์'.$leaveType->title)?>
  <?php
   $items['start_part']=$form->field($model, 'start_part')->dropdownList(Leave::getItemStartPart())->label(false)->error(false)->hint(false);
   $items['end_part']=$form->field($model, 'end_part')->dropdownList(Leave::getItemEndPart())->label(false)->hint(false)->error(false);
 ?>
 
    <div class="row">
        <div class="col-sm-6">
        <?=$form->field($model, 'date_start', [
            'inputTemplate' => '{input}',
            'options' => [
                'style' => 'width: 80%; float:left'
            ]
        ])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => LeaveDayOff::getList()]]);?>
        
        <div style="width: 20%; float: left;"><label class="control-label">&nbsp;</label>
                <?=$form->field($model, 'start_part')->dropdownList(Leave::getItemStartPart())->label(false)->error(false)->hint(false);?>
            </div>
        </div>
        
     <div class="col-sm-6">
       <?=$form->field($model, 'date_end', [
            'inputTemplate' => '{input}',
            'options' => [
                'style' => 'width: 80%; float:left'
            ]
        ])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => LeaveDayOff::getList()]]);?>
            
           <div style="width: 20%; float: left;"><label class="control-label">&nbsp;</label>
           <?=$form->field($model, 'end_part')->dropdownList(Leave::getItemEndPart())->label(false)->hint(false)->error(false);?>
           </div>
        </div>
    </div>
     
 <div class="row">
        <div class="col-sm-4">
             <?=$form->field($model, 'contact')->widget(TypeAhead::classname(),[
            'options' => ['placeholder' => 'ติดต่อข้าพเจ้าได้ที่'],
            'pluginOptions' => ['highlight'=>true],
            'defaultSuggestions' => Draft::getContactList(),
            'dataset' => [
                [
                    'local' => Draft::getContactList(),
                    'limit' => 10
                ]
            ]
        ]);
        ?>
         </div>
        
        <div class="col-sm-4">
             <?=$form->field($model, 'acting_user_id')->widget(Select2::classname(), [
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
    ?>
      </div>
    </div>
     
     
  <hr/>
<?=Html::tag('h4',Yii::t('andahrm/leave','Leave Relateds'))?>
    <div class="row">
        <div class="col-sm-4">
        
        <?=$form->field($model, 'inspector_by')->dropdownList($personLeave->inspectors); ?>
        
        </div>
        
        <div class="col-sm-4">
        
        <?= $form->field($model, 'commander_by')->dropdownList($personLeave->commanders); ?>
        
        </div>
        
        <div class="col-sm-4">
        
        <?= $form->field($model, 'director_by')->dropdownList($personLeave->directors); ?>
        
        </div>
    </div>




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