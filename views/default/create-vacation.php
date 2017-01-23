<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveDayOff;

use andahrm\leave\models\PersonLeave;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Create Leave Vacation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

# Candidate
$items=[];
$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
$items['user'] = $personLeave;

if($model->isNewRecord){
  $model->to = $personLeave->toDirector;
}
?>

<div class="leave-form">

 <?php $form = ActiveForm::begin();
  
  $items['created_at']=$model->isNewRecord ?'วันที่ '.Yii::$app->formatter->asDate('now','d').' เดือน '.Yii::$app->formatter->asDate('now','MMMM').' พ.ศ '.Yii::$app->formatter->asDate('now','yyyy'):'วันที่ '.Yii::$app->formatter->asDate($model->created_at,'d').' เดือน '.Yii::$app->formatter->asDate($model->created_at,'MMMM').' พ.ศ. '.Yii::$app->formatter->asDate($model->created_at,'yyyy'); 
  
  $items['user_id']=$form->field($model, 'user_id')->textInput(); 
  
  $items['to']=$form->field($model, 'to')->textInput(['placeholder'=>'เรียน']);
  
  $items['leave_type_id']=$form->field($model, 'leave_type_id')->textInput();
  
  $part = [1=>'ทั้งวัน',2=>'ครี่งวันเช้า',3=>'ครึ่งวันบ่าย'];
    
   $items['start_part']=$form->field($model, 'start_part')->dropdownList(Leave::getItemStartPart())->label(false)->error(false)->hint(false);

   $items['end_part']=$form->field($model, 'end_part')->dropdownList(Leave::getItemEndPart())->label(false)->hint(false)->error(false);
  
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
  
  
  /*$items['date_range']= DatePicker::widget([
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
        'startDate' => date('Y-m-d', strtotime("+1 day")),
        //'endDate' => date('Y-m-d', strtotime("+4 day")),
        //'calendarWeeks' => true,
        'daysOfWeekDisabled' => [0, 6],
    ]
]);*/

  
  $items['date_range']=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_RANGE,
    'options' => ['placeholder' => 'Enter birth date ...'],
    'attribute2' => 'date_end',
    'options2' => ['placeholder' => 'Enter birth date ...'],
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
 // $items['date_range'] .= $model->getFirstError('end_part');
  
    $items['contact']=$form->field($model, 'contact')->textInput(['placeholder'=>'ติดต่อข้าพเจ้าได้ที่']);

    $items['reason']=$form->field($model, 'reason')->textarea(['rows' => 6]);
  
    //$items['status']=$form->field($model, 'status')->hiddenInput()->label(false)->hint(false);

     $items['acting_user_id'] = $form->field($model, 'acting_user_id')->dropdownList(Leave::getActingList(),['prompt'=>'เลือกผู้ปฎิบัติราชการแทน']);
  
      $items['acting_user'] = '(...........................................................)'; 
  
      $items['inspectors'] = $form->field($model, 'inspector_by')->dropdownList($personLeave->inspectors,['prompt'=>'เลือกผู้ตรวจสอบ']);
      $items['inspector_at'] = $model->inspector_at?'วันที่ <span class="text-dashed">'.Yii::$app->formatter->asDate($model->inspector_at,'d').' / '.Yii::$app->formatter->asDate($model->inspector_at,'MMMM').' / '.Yii::$app->formatter->asDate($model->inspector_at,'yyyy').'</span>':'วันที่............./............................/................ ' ; 


    $items['commanders'] = $form->field($model, 'commander_by')->dropdownList($personLeave->commanders,['prompt'=>'เลือกผู้บังคับบัญชา']);

    $items['directors'] = $form->field($model, 'director_by')->dropdownList($personLeave->directors,['prompt'=>'เลือกผู้ออกคำสั่ง']);
  
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
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/leave', 'Create') : Yii::t('andahrm/leave', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

