<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\datepicker\DatePicker;
use andahrm\leave\models\LeaveDayOff;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */
/* @var $form yii\widgets\ActiveForm */


$template = "user : {user} ";
$items=[];
print_r(LeaveDayOff::getList());

?>

<div class="leave-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php $items['user_id']=$form->field($model, 'user_id')->textInput(); ?>

    <?php $items['leave_type_id']=$form->field($model, 'leave_type_id')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'date_start')->widget(DatePicker::classname(), [
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
    ]);?>
  
  
  
  
  
  

    <?php $items['date_start']=$form->field($model, 'start_part')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'date_end')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'end_part')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?php $items['date_start']=$form->field($model, 'acting_user_id')->textInput() ?>

    <?php /* $items['date_start']=$form->field($model, 'status')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'inspector_comment')->textInput(['maxlength' => true]) ?>

    <?php $items['date_start']=$form->field($model, 'inspector_status')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'inspector_by')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'inspector_at')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'commander_comment')->textInput(['maxlength' => true]) ?>

    <?php $items['date_start']=$form->field($model, 'commander_status')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'commander_by')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'commanded_at')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'director_comment')->textInput(['maxlength' => true]) ?>

    <?php $items['date_start']=$form->field($model, 'director_status')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'director_by')->textInput() ?>

    <?php $items['date_start']=$form->field($model, 'director_at')->textInput() */ ?>
 
  $layout3 = <<< HTML
    <span class="input-group-addon">From Date</span>
    {input1}
    <span class="input-group-addon">aft</span>
    {separator}
    <span class="input-group-addon">To Date</span
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;
 
echo DatePicker::widget([
    'type' => DatePicker::TYPE_RANGE,
    'name' => 'dp_addon_3a',
    'value' => '01-Jul-2015',
    'name2' => 'dp_addon_3b',
    'value2' => '18-Jul-2015',
    'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
    'layout' => $layout3,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'dd-M-yyyy'
    ]
]);
  
  
  
    <?=$this->render('template-sick',$items)?>
  

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
