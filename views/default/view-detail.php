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
?>




<?php #echo $this->render('wizard/_template-' . (($model->leave_type_id == Leave::TYPE_VACATION) ? 'vacation' : 'sick'), $items) ?>
<?php
$template_no = $model->leaveType->template_no;
echo $this->render('wizard/_template-' . $template_no, $items);
?>

