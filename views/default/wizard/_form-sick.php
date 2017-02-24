<?php 

use yii\helpers\Html;
//use kartik\widgets\DatePicker;

use kuakling\datepicker\DatePicker;
use kartik\widgets\Typeahead;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\LeaveDayOff;
use andahrm\leave\models\Draft;

use andahrm\leave\models\PersonLeave;
use andahrm\structure\models\FiscalYear;    
    
    # Candidate
    $items=[];
    $personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
    $items['user'] = $personLeave;
    $personLeave = $personLeave->position->section->leaveRelatedSection;
    if($model->isNewRecord){
      $model->to = $personLeave->toDirector;
    }    
    
    echo $form->field($model, 'leave_type_id')->hiddenInput()->label(false);
    
    $model->year = FiscalYear::currentYear();
    echo $form->field($model, 'year')->hiddenInput()->label(false);
    
    echo $model->scenario;
?>


<div class="row">
    <div class="col-sm-4">
    <?=$form->field($model, 'to')->textInput(['placeholder'=>'เรียน']);?>
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
    <?=$form->field($model, 'reason')->widget(TypeAhead::classname(),[
        'options' => ['placeholder' => 'เหตุผล'],
        'pluginOptions' => ['highlight'=>true],
        'defaultSuggestions' => Draft::getReasonList(),
        'dataset' => [
            [
                'local' => Draft::getReasonList(),
                'limit' => 10
            ]
        ]
        ]);
    ?>
</div>
</div>

    <?php
  
//   $layout3 = <<< HTML
//     <span class="input-group-addon">ตั้งแต่วันที่</span>
//     {input1}
//     <span class="input-group-addon">ถึงวันที่</span>
//     {input2}
//     <span class="input-group-addon kv-date-remove">
//         <i class="glyphicon glyphicon-remove"></i>
//     </span>
// HTML;
  
  
//   echo  DatePicker::widget([
//     'type' => DatePicker::TYPE_RANGE,
//     //'name' => 'dp_addon_3a',
//     'model' => $model,
//     'attribute' => 'date_start',
//     'attribute2' => 'date_end',
//     //'value' => '01-Jul-2015',
//     //'name2' => 'dp_addon_3b',
//     //'value2' => '18-Jul-2015',
//     'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
//     'layout' => $layout3,
//     'pluginOptions' => [
//         'autoclose' => true,
//         'datesDisabled' => LeaveDayOff::getList(),
//         'format' => 'yyyy-mm-dd',
//         'todayHighlight' => true,
//         'todayBtn' => true,
//         'endDate' => date('Y-m-d'),
//         //'calendarWeeks' => true,
//         'daysOfWeekDisabled' => [0, 6],
//     ]
// ]);
  
//   $items['date_start']=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
//     'options' => ['placeholder' => 'Enter birth date ...'],
//     'pluginOptions' => [
//         'autoclose'=>true,
//         'datesDisabled' => LeaveDayOff::getList(),
//         'format' => 'yyyy-mm-dd',
//         'todayHighlight' => true,
//         'todayBtn' => true,
//         'startDate' => date('Y-m-d', strtotime("+4 day")),
//         //'calendarWeeks' => true,
//         'daysOfWeekDisabled' => [0, 6],
        
//     ],
//     'pluginEvents'=>[
        
//     ]
//     ]);
?>
<div class="row">
    <div class="col-sm-6">
        <?=$form->field($model, 'date_start', [
            'inputTemplate' => '{input}',
            'options' => [
                'style' => 'width: 80%; float:left'
            ]
        ])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => LeaveDayOff::getList()]]);
        ?>
        <div style="width: 20%; float: left;"><label class="control-label">&nbsp;</label>
            <?=$form->field($model, 'start_part')->dropdownList(Leave::getItemStartPart())->label(false)->error(false)->hint(false);?>
        </div>
    </div>
    
    <div class="col-sm-6">
        <?= $form->field($model, 'date_end', [
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
</div>
    
         
<div class="row">
    <div class="col-sm-4">
    
    <?=$form->field($model, 'inspector_by')->dropdownList($personLeave->inspectors,['prompt'=>'เลือกผู้ตรวจสอบ']); ?>
    
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
    
    <?= $form->field($model, 'commander_by')->dropdownList($personLeave->commanders,['prompt'=>'เลือกผู้บังคับบัญชา']); ?>
    
    </div>
</div>

<div class="row">
    <div class="col-sm-4">
    
    <?= $form->field($model, 'director_by')->dropdownList($personLeave->directors,['prompt'=>'เลือกผู้ออกคำสั่ง']); ?>
    
    </div>
</div>
  
    