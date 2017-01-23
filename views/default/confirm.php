<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveDayOff;

use andahrm\person\models\Person;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Confirm Leave Vacation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

# Candidate
$items=[];
$items['user'] = Person::findOne(Yii::$app->user->identity->id);
?>

<div class="leave-form">

    <?php $form = ActiveForm::begin();
  echo $form->field($model, 'status')->hiddenInput()->label(false)->hint(false);
  
  $items['created_at']='วันที่ '.Yii::$app->formatter->asDate($model->created_at,'d').' เดือน '.Yii::$app->formatter->asDate($model->created_at,'MMMM').' พ.ศ. '.Yii::$app->formatter->asDate($model->created_at,'yyyy'); 
  
  $items['user_id']=$model->user_id; 
  
  $items['to']='เรียน <span class="text-dashed">'.$model->to.'</span>'; 
  
  $items['leave_type_id']=$model->leave_type_id;
 
  $items['date_range']= Yii::$app->formatter->asDate($model->date_start)
    .' '.$model->start_part.' ถึง '
    .Yii::$app->formatter->asDate($model->date_end).' '.$model->end_part;
  
  $items['start_part']=$model->start_part;
  
  $items['end_part']=$model->end_part;
  
  $items['reason']=$model->reason;
  
   $items['contact']=$model->contact;
    
  $items['acting_user_id'] = '<span class="text-dashed">'.$model->actingUser->fullname.'</span>'; 

  
   $items['acting_user'] = '(<span class="text-dashed">'.$model->actingUser->fullname.'</span>)<br/>'; 
   $items['acting_user'] .= 'ตำแหน่ง .'.$model->actingUser->positionTitle; 
  
   $items['inspectors'] = '(<span class="text-dashed">'.$model->inspectorBy->fullname.'</span>)<br/>'; 
   $items['inspectors'] .= 'ตำแหน่ง '.$model->inspectorBy->positionTitle; 
   $items['inspector_at'] = 'วันที่............./............................/................ ' ;

   $items['commanders'] = '(<span class="text-dashed">'.$model->commanderBy->fullname.'</span>)<br/>'; 
   $items['commanders'] .= 'ตำแหน่ง '.$model->commanderBy->positionTitle; 
  

   $items['directors'] = '(<span class="text-dashed">'.$model->directorBy->fullname.'</span>)<br/>'; 
   $items['directors'] .= 'ตำแหน่ง '.$model->directorBy->positionTitle; 
  ?>
  
  
  

    <?=$this->render('template-'.(($model->leave_type_id==4)?'vacation':'sick'),$items)?>
  

    <div class="form-group">
        <?= Html::a(Yii::t('andahrm/leave', 'Update'),['create-'.(($model->leave_type_id==4)?'vacation':'sick'),'id'=>$model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton(Yii::t('andahrm/leave', 'Confirm'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

