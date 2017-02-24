<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\LeaveDayOff;

use andahrm\leave\models\PersonLeave;
use andahrm\structure\models\FiscalYear;

use backend\widgets\WizardMenu;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Draft Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Create New'), 'url' => ['create','step'=>'reset']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Select Type'), 'url' => ['create','step'=>'select']];
$this->params['breadcrumbs'][] = $this->title;

# Candidate
$items=[];
$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
$items['user'] = $personLeave;


$modelDraft = $event->sender->read('draft')[0];
//$modelSelect$modelSelect->leave_type_id;
//print_r($modelSelect);
  
   $items['created_at'] = 'วันที่ '
   .Yii::$app->formatter->asDate(date('Y-m-d'),'d').' เดือน '.
   Yii::$app->formatter->asDate(date('Y-m-d'),'MMMM').' พ.ศ. '.
   Yii::$app->formatter->asDate(date('Y-m-d'),'yyyy'); 
  
  $items['user_id']=$modelDraft->created_by; 
  
  $items['to']='เรียน <span class="text-dashed">'.$modelDraft->to.'</span>'; 
  
  $items['leave_type_id']=$modelDraft->leave_type_id;
 
  $items['date_range']= '<span class="text-dashed">'.$modelDraft->date_start.'</span> '
    .'<span class="text-dashed">'.$modelDraft->startPartLabel.'</span> ถึง '
    .'<span class="text-dashed">'.$modelDraft->date_end.'</span> '
    .'<span class="text-dashed">'.$modelDraft->endPartLabel.'</span>';
  
   $items['number_day']=$modelDraft->number_day;
  
  $items['collect']=Leave::getCollect($modelDraft->createdBy,$modelDraft->year);
  
  $items['total']=$items['collect']+$items['user']->leavePermission->number_day;

  $items['start_part']=$modelDraft->start_part;
  
  $items['end_part']=$modelDraft->end_part;

  $items['pastDay']=Leave::getPastDay($modelDraft->createdBy,$modelDraft->year);
  
  $items['reason']=$modelDraft->reason;
  
   $items['contact']='<span class="text-dashed">'.$modelDraft->contact.'</span>';
    
  $items['acting_user_id'] = '<span class="text-dashed">'.$modelDraft->actingUser->fullname.'</span>'; 

  
  $items['acting_user'] = '(<span class="text-dashed">'.$modelDraft->actingUser->fullname.'</span>)<br/>'; 
   $items['acting_user'] .= 'ตำแหน่ง .'.$modelDraft->actingUser->positionTitle; 
  
   $items['inspector_status'] = Leave::getWidgetStatus($modelDraft->inspector_status,Leave::getItemInspactorStatus());
   $items['inspectors'] = '(<span class="text-dashed">'.$modelDraft->inspectorBy->fullname.'</span>)<br/>'; 
   $items['inspectors'] .= 'ตำแหน่ง '.$modelDraft->inspectorBy->positionTitle; 
   $items['inspector_comment'] = $modelDraft->inspector_comment?$modelDraft->inspector_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
   $items['inspector_at'] = $modelDraft->inspector_at?$modelDraft->inspectorAt:'วันที่............./............................/................ ' ; 

   $items['commander_status'] = Leave::getWidgetStatus($modelDraft->commander_status,Leave::getItemCommanderStatus());
   $items['commanders'] = '(<span class="text-dashed">'.$modelDraft->commanderBy->fullname.'</span>)<br/>'; 
   $items['commanders'] .= 'ตำแหน่ง '.$modelDraft->commanderBy->positionTitle; 
   $items['commander_comment'] = $modelDraft->commander_comment?$modelDraft->commander_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
   $items['commander_at'] = $modelDraft->commander_at?$modelDraft->commanderAt:'วันที่............./............................/................ ' ; 
  

   $items['director_status'] = Leave::getWidgetStatus($modelDraft->director_status,Leave::getItemDirectorStatus());
   $items['directors'] = '(<span class="text-dashed">'.$modelDraft->directorBy->fullname.'</span>)<br/>'; 
   $items['directors'] .= 'ตำแหน่ง '.$modelDraft->directorBy->positionTitle; 
   $items['director_comment'] = $modelDraft->director_comment?$modelDraft->director_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
   $items['director_at'] = $modelDraft->director_at?$modelDraft->directorAt:'วันที่............./............................/................ ' ; 
  
    

    
    if($modelSelect->leave_type_id==1){
        echo $this->render('../template-vacation',$items);
    }else{
        echo $this->render('../template-sick',$items);
    }
