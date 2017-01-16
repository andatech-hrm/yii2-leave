<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveDayOff;

use andahrm\person\models\Person;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Update {modelClass}: ', [
    'modelClass' => 'Leave',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/leave', 'Update');


# Candidate
$items=[];
$items['user'] = Person::findOne(Yii::$app->user->identity->id);
?>
<div class="leave-update">

    <?php $form = ActiveForm::begin();
  
  $items['user_id']=$form->field($model, 'user_id')->textInput(); 
  
  $items['leave_type_id']=$form->field($model, 'leave_type_id')->textInput();
  
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
        'startDate' => date('Y-m-d', strtotime("+1 day")),
        //'endDate' => date('Y-m-d', strtotime("+4 day")),
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
        'startDate' => date('Y-m-d', strtotime("+1 day")),
        //'calendarWeeks' => true,
        'daysOfWeekDisabled' => [0, 6],
        
    ],
    'pluginEvents'=>[
        
    ]
    ]);
  
  ?>

    <?php $items['start_part']=$form->field($model, 'start_part')->textInput() ?>

    <?php $items['end_part']=$form->field($model, 'end_part')->textInput() ?>

    <?php $items['reason']=$form->field($model, 'reason')->textarea(['rows' => 6]) ?>

    <?php $items['acting_user_id'] = $form->field($model, 'acting_user_id')->dropdownList(Leave::getActingList(),[]) ?>
 
 

   <?=$this->render('template-'.(($model->leave_type_id==4)?'vacation':'sick'),$items)?>
  

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm/leave', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



</div>
