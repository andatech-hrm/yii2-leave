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
use andahrm\leave\models\LeavePermissionTransection;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Confirm Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Create New'), 'url' => ['create', 'step' => 'reset']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Select Type'), 'url' => ['create', 'step' => 'select']];
$this->params['breadcrumbs'][] = $this->title;

//$modelSelect$modelSelect->leave_type_id;
//print_r($modelSelect);
//$modelSelect = $event->sender->read('select')[0];
?>
<div class="x_panel">
    <div class="x_title">
        <?= Html::tag('h2', $this->title . $leaveType->title) ?>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <?php
        $form = ActiveForm::begin();
//$model->status = 1;
        echo $form->field($model, 'status')->hiddenInput()->label(false);

        //$modelDraft = $model;
        $user_id = Yii::$app->user->id;

        #ผู้ขอ
        $items['user'] = $model->person;

        $items['created_at'] = 'วันที่ '
                . Yii::$app->formatter->asDate(date('Y-m-d'), 'd') . ' เดือน ' .
                Yii::$app->formatter->asDate(date('Y-m-d'), 'MMMM') . ' พ.ศ. ' .
                Yii::$app->formatter->asDate(date('Y-m-d'), 'yyyy');

        $items['user_id'] = Yii::$app->user->id;

        $items['to'] = 'เรียน <span class="text-dashed">' . $model->to . '</span>';

        $items['leave_type_id'] = $model->leave_type_id;

        $items['date_range'] = '<span class="text-dashed">' . Helper::dateBuddhistFormatter($model->date_start) . '</span> '
                . '<span class="text-dashed">' . $model->startPartLabel . '</span> ถึง '
                . '<span class="text-dashed">' . Helper::dateBuddhistFormatter($model->date_end) . '</span> '
                . '<span class="text-dashed">' . $model->endPartLabel . '</span>';

        $items['number_day'] = Leave::calCountDays(Helper::dateUi2Db($model->date_start), Helper::dateUi2Db($model->date_end), $model->start_part, $model->end_part);

        #ข้อมูลโควต้า
        $permisTrans = LeavePermissionTransection::getDataForForm($user_id, $model->year);

        $items['collect'] = $permisTrans[LeavePermissionTransection::CATE_CARRY];

        $items['yearly'] = $permisTrans[LeavePermissionTransection::CATE_YEARLY];

        $items['total'] = $permisTrans[LeavePermissionTransection::TOTAL];

        $items['start_part'] = $model->start_part;

        $items['end_part'] = $model->end_part;

        $items['pastDay'] = Leave::getPastDay($items['user_id'], $model->year);

        $items['reason'] = $model->reason;

        $items['contact'] = '<span class="text-dashed">' . $model->contact . '</span>';

        $items['actingUser'] = $model->actingUser;
        #################################################
        #ผู้ตรวจสอบ
        $inspectorBy = PersonLeave::findOne($model->inspector_by);
        $items['inspector']['status'] = Leave::getWidgetStatus($model->inspector_status, Leave::getItemInspactorStatus());
        $items['inspector']['name'] = '(<span class="text-dashed">' . $inspectorBy->fullname . '</span>)';
        $items['inspector']['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $inspectorBy->positionTitle . '</span>';
        $items['inspector']['comment'] = $model->inspector_comment ? $model->inspector_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $items['inspector']['at'] = $model->inspector_at ? $model->inspectorAt : '';
// //$items['inspector'] = $inspector ; 
// 
        #ผู้บังคับบัญชา
        $commanderBy = PersonLeave::findOne($model->commander_by);
        $items['commander']['status'] = Leave::getWidgetStatus($model->commander_status, Leave::getItemCommanderStatus());
        $items['commander']['name'] = '(<span class="text-dashed">' . $commanderBy->fullname . '</span>)';
        $items['commander']['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $commanderBy->positionTitle . '</span>';
        $items['commander']['comment'] = $model->commander_comment ? $model->commander_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $items['commander']['at'] = $model->commander_at ? $model->commanderAt : '';
//$items['commander'] = $commander ; 
//
        #ผู้ออกคำสั่ง 
        $directorBy = PersonLeave::findOne($model->director_by);
        $items['director']['status'] = Leave::getWidgetStatus($model->director_status, Leave::getItemDirectorStatus());
        $items['director']['name'] = '(<span class="text-dashed">' . $directorBy->fullname . '</span>)';
        $items['director']['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $directorBy->positionTitle . '</span>';
        $items['director']['comment'] = $model->director_comment ? $model->director_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        $items['director']['at'] = $model->director_at ? $model->directorAt : '';
//$items['director'] = $director ; 
//print_r($commander);
        #################################################
        $items['model'] = $model;
        $template_no = $model->leaveType->template_no;
        echo $this->render('templates/_view-' . $template_no, $items);
        echo $this->render('_button', $items);
        ?>





        <?php ActiveForm::end(); ?>
    </div>
</div>

