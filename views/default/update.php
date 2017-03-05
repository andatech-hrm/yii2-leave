<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kuakling\datepicker\DatePicker;
use kartik\widgets\Typeahead;

use andahrm\leave\models\Leave;
use andahrm\leave\models\Draft;
use andahrm\leave\models\LeaveDayOff;

use andahrm\person\models\Person;
use andahrm\leave\models\PersonLeave;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use andahrm\setting\models\Helper;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm', 'Update {modelClass}: ', [
    'modelClass' => 'Leave',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');


# Candidate
$items=[];
$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
$items['user'] = $personLeave;
?>
<div class="leave-update">

    <?php $form = ActiveForm::begin();
  
  $items['created_at'] = 'วันที่ '.Yii::$app->formatter->asDate($model->created_at,'d').' เดือน '.Yii::$app->formatter->asDate($model->created_at,'MMMM').' พ.ศ. '.Yii::$app->formatter->asDate($model->created_at,'yyyy'); 
  
  $items['year']=$model->year; 
  
  $items['user_id']=$model->created_by; 
  
  $items['to']=$form->field($model, 'to')->textInput(['placeholder'=>'เรียน']);
  
  
  $items['leave_type_id']=$model->leave_type_id;
  
  $layout3 = <<< HTML
    <span class="input-group-addon">ตั้งแต่วันที่</span>
    {input1}
    <span class="input-group-addon">ถึงวันที่</span>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;
  
  $items['date_range']= '<span class="text-dashed">'.Yii::$app->formatter->asDate($model->date_start).'</span> '
    .'<span class="text-dashed">'.$model->startPartLabel.'</span> ถึง '
    .'<span class="text-dashed">'.Yii::$app->formatter->asDate($model->date_end).'</span> '
    .'<span class="text-dashed">'.$model->endPartLabel.'</span>';
  
        
  
  $items['date_range_input']= $form->field($model, 'date_start',['options'=>['class'=>'form-group col-sm-4']])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => LeaveDayOff::getList()]])
  .$form->field($model, 'start_part',['options'=>['class'=>'form-group col-sm-2']])->dropdownList(Leave::getItemStartPart())
  .$form->field($model, 'date_end',['options'=>['class'=>'form-group col-sm-4']])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => LeaveDayOff::getList()]])
  .$form->field($model, 'end_part',['options'=>['class'=>'form-group col-sm-2']])->dropdownList(Leave::getItemEndPart());;
  
  $items['collect']=Leave::getCollect($model->createdBy,$model->year);
    

   $items['number_day']=$model->number_day;
  
  $items['collect']=Leave::getCollect($model->createdBy,$model->year);
  
  $items['total']=$items['collect']+$items['user']->leavePermission->number_day;
  
  $items['pastDay']=Leave::getPastDay($model->createdBy,$model->year);
  
  
  
  $items['contact']=$form->field($model, 'contact')->widget(TypeAhead::classname(),[
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
        
        
    if($model->scenario==Leave::SCENA_UPDATE_VACATION){
      $items['acting_user_id'] = $form->field($model, 'acting_user_id')->widget(Select2::classname(), [
        //'initValueText' => $cityDesc, // set the initial display text
        'data'=>PersonLeave::getList(),
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
    }else{
      
      $items['reason']=$form->field($model, 'reason')->widget(TypeAhead::classname(),[
            'options' => ['placeholder' => 'เหตุผล'],
            'pluginOptions' => ['highlight'=>true],
            'defaultSuggestions' => Draft::getReasonList(),
            'dataset' => [
                [
                    'local' => Draft::getReasonList(),
                    'limit' => 10
                ]
            ]
            ]);;
      
    }
    
    
    $personLeave = $personLeave->position->section->leaveRelatedSection;
    $items['inspector_input'] = $form->field($model, 'inspector_by')->dropdownList($personLeave->inspectors); 
    $items['commander_input'] = $form->field($model, 'commander_by')->dropdownList($personLeave->commanders); 
    $items['director_input'] = $form->field($model, 'director_by')->dropdownList($personLeave->directors); 
  
    
    $items['model'] = $model?>
 
 
 

   <?php #$this->render('template-'.(($model->leave_type_id==4)?'vacation':'sick'),$items)?>
  

  <?=$this->render('wizard/_template-'.(($model->leave_type_id==Leave::TYPE_VACATION)?'vacation':'sick'),$items)?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm', 'Update'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>



</div>
