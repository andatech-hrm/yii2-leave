<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
//use kuakling\datepicker\DatePicker;

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

# Candidate
$items=[];
$items['user'] = PersonLeave::findOne(Yii::$app->user->identity->id);
?>

<div class="leave-form">
<?='ปีงบประมาณ '.FiscalYear::currentYear()?>
 <?php $form = ActiveForm::begin();
    $modelCancel->leave_id = $model->id;
  echo $form->field($modelCancel, 'leave_id')->textInput(['placeholder'=>'เรียน']);
  
  $items['created_at']=$modelCancel->isNewRecord ?'วันที่ '.Yii::$app->formatter->asDate('now','d').' เดือน '.Yii::$app->formatter->asDate('now','MMMM').' พ.ศ '.Yii::$app->formatter->asDate('now','yyyy'):'วันที่ '.Yii::$app->formatter->asDate($model->created_at,'d').' เดือน '.Yii::$app->formatter->asDate($model->created_at,'MMMM').' พ.ศ. '.Yii::$app->formatter->asDate($model->created_at,'yyyy'); 
  
  
  $items['to']=$form->field($modelCancel, 'to')->textInput(['placeholder'=>'เรียน']);
  
  $items['leave_type_id']=$model->leaveType->title;
  
  #จำนวนวันที่ลาครั้งนี้
  $items['number_day']=$model->number_day?$model->number_day:0;
  
  $items['collect']=Leave::getCollect(Yii::$app->user->id,$model->year,$model->leave_type_id);
  
  $items['total']=$items['collect']+$items['user']->leavePermission->number_day;
  
  
$items['date_range_old']= 'ตั้งแต่วันที่ <span class="text-dashed">'.Yii::$app->formatter->asDate($model->date_start).'</span>'
    .'<span class="text-dashed">'.$model->startPartLabel.'</span> ถึง '
    .'<span class="text-dashed">'.Yii::$app->formatter->asDate($model->date_end).'</span>'
    .'<span class="text-dashed">'.$model->endPartLabel.'</span>';
    
   $items['start_part']=$form->field($modelCancel, 'start_part')->dropdownList(Leave::getItemStartPart())->label(false)->error(false)->hint(false);

   $items['end_part']=$form->field($modelCancel, 'end_part')->dropdownList(Leave::getItemEndPart())->label(false)->hint(false)->error(false);
  
  
  $layout3 = <<< HTML
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
  
    
  $items['date_range']=$form->field($modelCancel, 'date_start')->widget(DatePicker::classname(), [
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
        'startDate' => $model->date_start,
        'endDate' => $model->date_end,
        //'calendarWeeks' => true,
        'daysOfWeekDisabled' => [0, 6],
    ],
    'pluginEvents'=>[
        
    ]
    ])->label(false);
    
    
  $items['date_range'] .= $model->getFirstError('end_part');
  
    $items['contact']=$form->field($model, 'contact')->textInput(['placeholder'=>'ติดต่อข้าพเจ้าได้ที่']);
  
      $items['pastDay']=Leave::getPastDay();

     $items['reason']=$form->field($modelCancel, 'reason')->textInput(['placeholder'=>'เนื่องจาก'])->label(false);
    
  

    $items['commanders'] = $form->field($modelCancel, 'commander_by')->dropdownList($personLeave->commanders,['prompt'=>'เลือกผู้บังคับบัญชา']);
    $items['commander_status'] = Leave::getWidgetStatus($modelCancel->commander_status,Leave::getItemCommanderStatus());
    $items['commander_comment'] = $model->commander_comment?$modelCancel->commander_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
   $items['commander_at'] = $modelCancel->commander_at?$modelCancel->commanderAt:'วันที่............./............................/................ ' ; 
  
  
  $items['director_status'] = Leave::getWidgetStatus($modelCancel->director_status,Leave::getItemDirectorStatus());
    $items['directors'] = $form->field($modelCancel, 'director_by')->dropdownList($personLeave->directors,['prompt'=>'เลือกผู้ออกคำสั่ง']);
   $items['director_comment'] = $modelCancel->director_comment?$modelCancel->director_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
   $items['director_at'] = $modelCancel->director_at?$modelCancel->directorAt:'วันที่............./............................/................ ' ; 

  
?>
 
<?php 
  if($model->hasErrors()):?>
    <div class="alert alert-warning alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <strong>คำเดือน</strong> <?=$model->getAttributeLabel('end_part').":".$model->getFirstError('end_part')?>
    </div>
  <?php  endif;?>

    <?=$this->render('template-cancel',$items)?>
  

    <div class="form-group">
        <?= Html::submitButton($modelCancel->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $modelCancel->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

