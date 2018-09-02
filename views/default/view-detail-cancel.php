<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use andahrm\leave\models\Leave;
use andahrm\leave\models\PersonLeave;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */
?>



<?php

# Candidate
$items = [];
$items['model'] = $model->leave;
$items['user'] = $model->createdBy;

$items['created_at'] = 'วันที่ ' . Yii::$app->formatter->asDate($model->updated_at, 'd') . ' เดือน ' . Yii::$app->formatter->asDate($model->updated_at, 'MMMM') . ' พ.ศ. ' . Yii::$app->formatter->asDate($model->updated_at, 'yyyy');

$items['user_id'] = $model->created_by;

$items['to'] = 'เรียน <span class="text-dashed">' . $model->to . '</span>';

//$items['leave_type_id']=$model->leave_type_id;

$items['date_range'] = '<span class="text-dashed">' . Yii::$app->formatter->asDate($model->date_start) . '</span> '
        . '<span class="text-dashed">' . $model->startPartLabel . '</span> ถึง '
        . '<span class="text-dashed">' . Yii::$app->formatter->asDate($model->date_end) . '</span> '
        . '<span class="text-dashed">' . $model->endPartLabel . '</span>';

$items['number_day'] = $model->number_day;

$items['collect'] = Leave::getCollect($model->createdBy, $model->leave->year);

$items['total'] = $items['collect'] + $items['user']->leavePermission->number_day;

$items['start_part'] = $model->start_part;

$items['end_part'] = $model->end_part;

$items['pastDay'] = Leave::getPastDay($model->createdBy, $model->leave->year);

$items['reason'] = $model->reason;

//$items['contact']='<span class="text-dashed">'.$model->contact.'</span>';
// $items['acting_user_id'] = '<span class="text-dashed">'.$model->actingUser->fullname.'</span>'; 
//   $items['acting_user'] = '(<span class="text-dashed">'.$model->actingUser->fullname.'</span>)<br/>'; 
//   $items['acting_user'] .= 'ตำแหน่ง .'.$model->actingUser->positionTitle; 
//   $items['inspector_status'] = Leave::getWidgetStatus($model->inspector_status,Leave::getItemInspactorStatus());
//   $items['inspectors'] = '(<span class="text-dashed">'.$model->inspectorBy->fullname.'</span>)<br/>'; 
//   $items['inspectors'] .= 'ตำแหน่ง '.$model->inspectorBy->positionTitle; 
//   $items['inspector_comment'] = $model->inspector_comment?$model->inspector_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
//   $items['inspector_at'] = $model->inspector_at?$model->inspectorAt:'วันที่............./............................/................ ' ; 
//   $items['commander_status'] = Leave::getWidgetStatus($model->commander_status,Leave::getItemCommanderStatus());
//   $items['commanders'] = '(<span class="text-dashed">'.$model->commanderBy->fullname.'</span>)<br/>'; 
//   $items['commanders'] .= 'ตำแหน่ง '.$model->commanderBy->positionTitle; 
//   $items['commander_comment'] = $model->commander_comment?$model->commander_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
//   $items['commander_at'] = $model->commander_at?$model->commanderAt:'วันที่............./............................/................ ' ; 
//   $items['director_status'] = Leave::getWidgetStatus($model->director_status,Leave::getItemDirectorStatus());
//   $items['directors'] = '(<span class="text-dashed">'.$model->directorBy->fullname.'</span>)<br/>'; 
//   $items['directors'] .= 'ตำแหน่ง '.$model->directorBy->positionTitle; 
//   $items['director_comment'] = $model->director_comment?$model->director_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
//   $items['director_at'] = $model->director_at?$model->directorAt:'วันที่............./............................/................ ' ; 

$items['modelCancel'] = $model;
?>




<?= $this->render('template-cancel', $items) ?>


