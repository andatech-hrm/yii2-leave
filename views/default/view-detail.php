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
$items['user'] = $model->createdBy;

$items['created_at'] = 'วันที่ ' . Yii::$app->formatter->asDate($model->created_at, 'd') . ' เดือน ' . Yii::$app->formatter->asDate($model->created_at, 'MMMM') . ' พ.ศ. ' . Yii::$app->formatter->asDate($model->created_at, 'yyyy');

$items['year'] = $model->year;

$items['user_id'] = $model->created_by;

$items['to'] = 'เรียน <span class="text-dashed">' . $model->to . '</span>';

$items['leave_type_id'] = $model->leave_type_id;

$items['date_range'] = '<span class="text-dashed">' . Yii::$app->formatter->asDate($model->date_start) . '</span> '
        . '<span class="text-dashed">' . $model->startPartLabel . '</span> ถึง '
        . '<span class="text-dashed">' . Yii::$app->formatter->asDate($model->date_end) . '</span> '
        . '<span class="text-dashed">' . $model->endPartLabel . '</span>';

$items['number_day'] = $model->number_day;

$items['collect'] = Leave::getCollect($model->createdBy, $model->year);

$items['total'] = $items['collect'] + $items['user']->leavePermission->number_day;

$items['start_part'] = $model->start_part;

$items['end_part'] = $model->end_part;

$items['pastDay'] = $model->pastDayBefore;

$items['reason'] = $model->reason;

$items['contact'] = '<span class="text-dashed">' . $model->contact . '</span>';

// $items['acting_user_id'] = '<span class="text-dashed">'.$model->actingUser->fullname.'</span>'; 
// $items['acting_user'] = '(<span class="text-dashed">'.$model->actingUser->fullname.'</span>)<br/>'; 
// $items['acting_user'] .= 'ตำแหน่ง .'.$model->actingUser->positionTitle; 

$items['model'] = $model;



#ผู้ขอ
$items['user'] = $model->person;

#ผู้แทน
$items['actingUser'] = $model->actingUser;

#ข้อมูลประเภทการลา
$items['leaveType'] = $model->leaveType;

#ข้อมูลโควต้า
//$permisTrans = LeavePermissionTransection::getDataForForm($user_id, $model->year);
//print_r($permisTrans);
//exit();
#ผู้ตรวจสอบ
$inspectorBy = PersonLeave::findOne($model->inspector_by);
$items['inspector']['status'] = Leave::getWidgetStatus($model->inspector_status, Leave::getItemInspactorStatus());
$items['inspector']['name'] = '(<span class="text-dashed">' . $inspectorBy->fullname . '</span>)';
$items['inspector']['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $inspectorBy->positionTitle . '</span>';
$items['inspector']['comment'] = $model->inspector_comment ? $model->inspector_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$items['inspector']['at'] = $model->inspector_at ? $model->inspectorAt : '';
// //$items['inspector'] = $inspector ; 
#ผู้บังคับบัญชา
$commanderBy = PersonLeave::findOne($model->commander_by);
$items['commander']['status'] = Leave::getWidgetStatus($model->commander_status, Leave::getItemCommanderStatus());
$items['commander']['name'] = '(<span class="text-dashed">' . $commanderBy->fullname . '</span>)';
$items['commander']['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $commanderBy->positionTitle . '</span>';
$items['commander']['comment'] = $model->commander_comment ? $model->commander_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$items['commander']['at'] = $model->commander_at ? $model->commanderAt : '';
//$items['commander'] = $commander ; 
#ผู้ออกคำสั่ง 
$directorBy = PersonLeave::findOne($model->director_by);
$items['director']['status'] = Leave::getWidgetStatus($model->director_status, Leave::getItemDirectorStatus());
$items['director']['name'] = '(<span class="text-dashed">' . $directorBy->fullname . '</span>)';
$items['director']['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $directorBy->positionTitle . '</span>';
$items['director']['comment'] = $model->director_comment ? $model->director_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$items['director']['at'] = $model->director_at ? $model->directorAt : '';
//$items['director'] = $director ; 
//print_r($commander);
?>




<?php #echo $this->render('wizard/_template-' . (($model->leave_type_id == Leave::TYPE_VACATION) ? 'vacation' : 'sick'), $items)  ?>
<?php

$template_no = $model->leaveType->template_no;
echo $this->render('templates/_view-' . $template_no, $items);
?>

