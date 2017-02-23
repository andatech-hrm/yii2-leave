<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\LeaveDayOff;

use andahrm\leave\models\PersonLeave;
use andahrm\structure\models\FiscalYear;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Create Leave Sick');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

# Candidate
$items=[];
$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
$items['user'] = $personLeave;
$personLeave = $personLeave->position->section->leaveRelatedSection;
if($model->isNewRecord){
  echo $model->to = $personLeave->toDirector;
}
?>

<div class="leave-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php 
    
    $items['created_at']=$model->isNewRecord ?'วันที่ '.Yii::$app->formatter->asDate('now','d').' เดือน '.Yii::$app->formatter->asDate('now','MMMM').' พ.ศ '.Yii::$app->formatter->asDate('now','yyyy'):'วันที่ '.Yii::$app->formatter->asDate($model->created_at,'d').' เดือน '.Yii::$app->formatter->asDate($model->created_at,'MMMM').' พ.ศ. '.Yii::$app->formatter->asDate($model->created_at,'yyyy'); 
  
    $items['user_id']=$form->field($model, 'user_id')->textInput(); 
    
    $items['to']=$form->field($model, 'to')->textInput(['placeholder'=>'เรียน']);
    
    $items['leave_type_id']=$form->field($model, 'leave_type_id')->radioList(LeaveType::getList(),[
            'item' => function($index, $label, $name, $checked, $value) {
                $return = '<label class="modal-radio">';
                $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3" '.($checked?'checked="checked"':'').' >';
                $return .= ' <i class="fa fa-user"></i> ';
                $return .= ' <span>' . ucwords($label) . '</span>';
                $return .= '</label><br/>';

                return $return;
            }
        ]);
    
    $items['reason']=$form->field($model, 'reason')->textInput();
  
  $layout3 = <<< HTML
    <span class="input-group-addon">ตั้งแต่วันที่</span>
    {input1}
    <span class="input-group-addon">ถึงวันที่</span>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;
  
  
  $items['date_range']= DatePicker::widget([
    'type' => DatePicker::TYPE_RANGE,
    //'name' => 'dp_addon_3a',
    'model' => $model,
    'attribute' => 'date_start',
    'attribute2' => 'date_end',
    //'value' => '01-Jul-2015',
    //'name2' => 'dp_addon_3b',
    //'value2' => '18-Jul-2015',
    'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
    'layout' => $layout3,
    'pluginOptions' => [
        'autoclose' => true,
        'datesDisabled' => LeaveDayOff::getList(),
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'todayBtn' => true,
        'endDate' => date('Y-m-d'),
        //'calendarWeeks' => true,
        'daysOfWeekDisabled' => [0, 6],
    ]
]);
  
  $items['date_start']=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'options' => ['placeholder' => 'Enter birth date ...'],
    'pluginOptions' => [
        'autoclose'=>true,
        'datesDisabled' => LeaveDayOff::getList(),
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'todayBtn' => true,
        'startDate' => date('Y-m-d', strtotime("+4 day")),
        //'calendarWeeks' => true,
        'daysOfWeekDisabled' => [0, 6],
        
    ],
    'pluginEvents'=>[
        
    ]
    ]);
    
    
    $items['contact']=$form->field($model, 'contact')->textInput(['placeholder'=>'ติดต่อข้าพเจ้าได้ที่']);
    
    
         
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
  
  
  
  
  
  

    <?php $items['date_start']=$form->field($model, 'start_part')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'date_end')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'end_part')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?php $items['date_start']=$form->field($model, 'acting_user_id')->textInput() ?>

    
 

    <?=$this->render('template-sick',$items)?>
  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

