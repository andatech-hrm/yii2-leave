<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use andahrm\person\models\Person;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */


?>

  

<?php
  
  # Candidate
$items=[];
$items['user'] = $model->createdBy;
  
   $items['created_at'] = 'วันที่ '.Yii::$app->formatter->asDate($model->created_at,'d').' เดือน '.Yii::$app->formatter->asDate($model->created_at,'MMMM').' พ.ศ. '.Yii::$app->formatter->asDate($model->created_at,'yyyy'); 
  
  $items['user_id']=$model->created_by; 
  
  $items['to']='เรียน <span class="text-dashed">'.$model->to.'</span>'; 
  
  $items['leave_type_id']=$model->leave_type_id;
 
  $items['date_range']= '<span class="text-dashed">'.Yii::$app->formatter->asDate($model->date_start).'</span> '
    .'<span class="text-dashed">'.$model->startPartLabel.'</span> ถึง '
    .'<span class="text-dashed">'.Yii::$app->formatter->asDate($model->date_end).'</span> '
    .'<span class="text-dashed">'.$model->endPartLabel.'</span>';
  
  $items['countDays']=$model->countDays;

  $items['start_part']=$model->start_part;
  
  $items['end_part']=$model->end_part;
  
  $items['reason']=$model->reason;
  
   $items['contact']='<span class="text-dashed">'.$model->contact.'</span>';
    
  $items['acting_user_id'] = '<span class="text-dashed">'.$model->actingUser->fullname.'</span>'; 

  
  $items['acting_user'] = '(<span class="text-dashed">'.$model->actingUser->fullname.'</span>)<br/>'; 
   $items['acting_user'] .= 'ตำแหน่ง .'.$model->actingUser->positionTitle; 
  
   $items['inspectors'] = '(<span class="text-dashed">'.$model->inspectorBy->fullname.'</span>)<br/>'; 
   $items['inspectors'] .= 'ตำแหน่ง '.$model->inspectorBy->positionTitle; 
   $items['inspector_at'] = $model->inspector_at?'วันที่ <span class="text-dashed">'.Yii::$app->formatter->asDate($model->inspector_at,'d').' / '.Yii::$app->formatter->asDate($model->inspector_at,'MMMM').' / '.Yii::$app->formatter->asDate($model->inspector_at,'yyyy').'</span>':'วันที่............./............................/................ ' ; 

   $items['commanders'] = '(<span class="text-dashed">'.$model->commanderBy->fullname.'</span>)<br/>'; 
   $items['commanders'] .= 'ตำแหน่ง '.$model->commanderBy->positionTitle; 
  

   $items['directors'] = '(<span class="text-dashed">'.$model->directorBy->fullname.'</span>)<br/>'; 
   $items['directors'] .= 'ตำแหน่ง '.$model->directorBy->positionTitle; 
  ?>
  
  
  

    <?=$this->render('template-'.(($model->leave_type_id==4)?'vacation':'sick'),$items)?>


