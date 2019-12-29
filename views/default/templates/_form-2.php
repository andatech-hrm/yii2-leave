<?php

use yii\helpers\Html;
//use kartik\widgets\DatePicker;
use andahrm\datepicker\DatePicker;
use kartik\widgets\Typeahead;
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\LeaveDayOff;
use andahrm\leave\models\Draft;
use andahrm\leave\models\PersonLeave;
use andahrm\structure\models\FiscalYear;

# Candidate
$items = [];
$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
$items['user'] = $personLeave;
$personLeave = $personLeave->position->section->leaveRelatedSection;
if ($model->isNewRecord) {
    $model->to = $personLeave->toDirector;
}
?>

<div class="row">
    <div class="col-sm-4">
        <?= $form->field($model, 'to')->textInput(['placeholder' => 'เรียน']); ?>
    </div>
</div>


<hr/>
<?= Html::tag('h4', 'มีความประสงค์' . $leaveType->title) ?>
<div class="row">
    <div class="col-sm-4">
        <?=
        $form->field($model, 'reason')->widget(TypeAhead::classname(), [
            'options' => ['placeholder' => 'เหตุผล'],
            'pluginOptions' => ['highlight' => true],
            'defaultSuggestions' => Draft::getReasonList() ? Draft::getReasonList() : [],
            'dataset' => [
                [
                    'local' => Draft::getReasonList() ? Draft::getReasonList() : [],
                    'limit' => 10
                ]
            ]
        ]);
        ?>
    </div>
</div>

<div class="row">
    <?= $form->field($model, 'date_start', ['options' => ['class' => 'form-group col-sm-4']])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => LeaveDayOff::getList()]]); ?>
    <?= $form->field($model, 'start_part', ['options' => ['class' => 'form-group col-sm-2']])->dropdownList(Leave::getItemStartPart()); ?>
    <?= $form->field($model, 'date_end', ['options' => ['class' => 'form-group col-sm-4']])->widget(DatePicker::className(), ['options' => ['daysOfWeekDisabled' => [0, 6], 'datesDisabled' => LeaveDayOff::getList()]]); ?>
    <?= $form->field($model, 'end_part', ['options' => ['class' => 'form-group col-sm-2']])->dropdownList(Leave::getItemEndPart()); ?>

</div>


<div class="row">
    <div class="col-sm-4">

        <?=
        $form->field($model, 'contact')->widget(TypeAhead::classname(), [
            'options' => ['placeholder' => 'ติดต่อข้าพเจ้าได้ที่'],
            'pluginOptions' => ['highlight' => true],
            'defaultSuggestions' => Draft::getContactList(),
            'dataset' => [
                [
                    'local' => Draft::getContactList(),
                    'limit' => 10
                ]
            ]
        ]);
        ?>

    </div>
</div>


<hr/>
<?= Html::tag('h4', Yii::t('andahrm/leave', 'Leave Relateds')) ?>         
<div class="row">
    <div class="col-sm-4">

        <?= $form->field($model, 'inspector_by')->dropdownList($personLeave->inspectors); ?>

    </div>

    <div class="col-sm-4">

        <?= $form->field($model, 'commander_by')->dropdownList($personLeave->commanders); ?>

    </div>

    <div class="col-sm-4">

        <?= $form->field($model, 'director_by')->dropdownList($personLeave->directors); ?>

    </div>
</div>

