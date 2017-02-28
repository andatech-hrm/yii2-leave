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
use andahrm\setting\models\Helper;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

# Candidate
$items=[];
$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
$items['user'] = $personLeave;
$items['user_id'] = Yii::$app->user->id;
$items['year'] = FiscalYear::currentYear();


$modelDraft = $event->sender->read('draft')[0];
//$modelSelect$modelSelect->leave_type_id;
//print_r($modelSelect);
  
   $items['created_at'] = 'วันที่ '
   .Yii::$app->formatter->asDate(date('Y-m-d'),'d').' เดือน '.
   Yii::$app->formatter->asDate(date('Y-m-d'),'MMMM').' พ.ศ. '.
   Yii::$app->formatter->asDate(date('Y-m-d'),'yyyy'); 
  
    //$items['user_id']=$modelDraft->created_by; 
    
    $items['to']='เรียน <span class="text-dashed">'.$modelDraft->to.'</span>'; 
    
    // $items['leave_type_id']=$modelDraft->leave_type_id;
    // $items['leave_type_title']=$modelDraft->leaveType->title;
    
      $items['date_range']= '<span class="text-dashed">'.Helper::dateBuddhistFormatter($modelDraft->date_start).'</span> '
    .'<span class="text-dashed">'.$modelDraft->startPartLabel.'</span> ถึง '
    .'<span class="text-dashed">'.Helper::dateBuddhistFormatter($modelDraft->date_end).'</span> '
    .'<span class="text-dashed">'.$modelDraft->endPartLabel.'</span>';
    
    $items['number_day']=Leave::calCountDays(Helper::dateUi2Db($modelDraft->date_start),Helper::dateUi2Db($modelDraft->date_end),$modelDraft->start_part,$modelDraft->end_part);
    
    $items['collect']=Leave::getCollect($modelDraft->createdBy,$modelDraft->year);
    
    $items['total']=$items['collect']+$items['user']->leavePermission->number_day;
    
    $items['start_part']=$modelDraft->start_part;
    
    $items['end_part']=$modelDraft->end_part;
    
    //$items['pastDay']=Leave::getPastDay($modelDraft->createdBy,$modelDraft->year);
    
    $items['reason']=$modelDraft->reason;
    
    $items['contact']='<span class="text-dashed">'.$modelDraft->contact.'</span>';
    
    $items['model'] = $modelDraft;
    //$commander['status'] = Leave::getWidgetStatus($modelDraft->commander_status,Leave::getItemCommanderStatus());
    //$commander['name'] = '(<span class="text-dashed">'.$modelDraft->commanderBy->fullname.'</span>)<br/>'; 
    //$commander['position'] = Yii::t('andahrm/position-salary','Position').' '.$modelDraft->commanderBy->position->title; 
    // $commander['comment'] = $modelDraft->commander_comment?$modelDraft->commander_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
    //$commander['at'] = $modelDraft->commander_at?$modelDraft->commanderAt:'' ; 
    // $items['commander'] = $commander ; 
    
    
    // $inspector['status'] = Leave::getWidgetStatus($modelDraft->inspector_status,Leave::getItemInspactorStatus());
   // $inspector['name'] = '(<span class="text-dashed">'.$modelDraft->inspectorBy->fullname.'</span>)<br/>'; 
    // $inspector['name'] .= Yii::t('andahrm/position-salary','Position').' '.$modelDraft->inspectorBy->positionTitle; 
    // $inspector['comment'] = $modelDraft->inspector_comment?$modelDraft->inspector_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
    //$inspector['at'] = $modelDraft->inspector_at?$modelDraft->inspectorAt:'' ; 
    // $items['inspector'] = $inspector ; 
    
    // $director['status'] = Leave::getWidgetStatus($modelDraft->director_status,Leave::getItemDirectorStatus());
    //$director['name'] = '(<span class="text-dashed">'.$modelDraft->directorBy->fullname.'</span>)<br/>'; 
    // $director['name'] .= Yii::t('andahrm/position-salary','Position').' '.$modelDraft->directorBy->positionTitle; 
    // $director['comment'] = $modelDraft->director_comment?$modelDraft->director_comment:'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' ; 
    //$director['at'] = $modelDraft->director_at?$modelDraft->directorAt:''; 
    // $items['director'] = $director ; 

// echo "<pre>";    
// print_r($modelDraft);
// exit();
    
  
        echo $this->render('_template-sick',$items);
    
