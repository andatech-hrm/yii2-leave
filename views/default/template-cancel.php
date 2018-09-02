<?php

use andahrm\leave\models\PersonLeave;
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveType;

//$model= $model->leave;
#ข้อมูลประเภทการลา
$leaveType = LeaveType::findOne($model->leave_type_id);


#ผู้ตรวจสอบ
//$inspectorBy = PersonLeave::findOne($model->inspector_by);
//$inspector['status'] = Leave::getWidgetStatus($modelCancel->inspector_status, Leave::getItemInspactorStatus());
//$inspector['name'] = '(<span class="text-dashed">' . $inspectorBy->fullname . '</span>)';
//$inspector['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $inspectorBy->positionTitle . '</span>';
//$inspector['comment'] = $model->inspector_comment ? $model->inspector_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
//$inspector['at'] = $model->inspector_at ? $model->inspectorAt : '';
// //$items['inspector'] = $inspector ; 
#ผู้บังคับบัญชา
$commanderBy = PersonLeave::findOne($modelCancel->commander_by);
$commander['status'] = Leave::getWidgetStatus($modelCancel->commander_status, Leave::getItemCommanderStatus());
$commander['name'] = '(<span class="text-dashed">' . $commanderBy->fullname . '</span>)';
$commander['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $commanderBy->positionTitle . '</span>';
$commander['comment'] = $modelCancel->commander_comment ? $modelCancel->commander_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$commander['at'] = $model->commander_at ? $model->commanderAt : '';
//$items['commander'] = $commander ;    
#ผู้ออกคำสั่ง 
$directorBy = PersonLeave::findOne($modelCancel->director_by);
$director['status'] = Leave::getWidgetStatus($modelCancel->director_status, Leave::getItemDirectorStatus());
$director['name'] = '(<span class="text-dashed">' . $directorBy->fullname . '</span>)';
$director['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $directorBy->positionTitle . '</span>';
$director['comment'] = $modelCancel->director_comment ? $modelCancel->director_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$director['at'] = $model->director_at ? $model->directorAt : '';
?>

<div class="font-thai-sarabun">

    <h2 class="text-center">แบบใบขอยกเลิกวันลา</h2>

    <p class="text-right">
        เขียนที่ <span class="text-dest-under">องค์การบริหารส่วนจังหวัดยะลา</span>
    </p>

    <p class="text-right">
<?= $created_at ?>
    </p>



    <p class="text-left">
        เรื่อง <span class="text-dashed">ขอยกเลิกวันลา</span>
    </p>

    <p class="text-left">
    <div class="row">
        <div class="col-sm-5">
<?= $to ?>
        </div>
    </div>
</p>
<p class="p-form-indent">

    ข้าพเจ้า <span class="text-dashed"><?= $user->fullname ?></span>
    ตำแหน่ง <span class="text-dashed"><?= $user->position->title ?></span>
    สังกัด <span class="text-dashed"><?= $user->position->section->title ?></span>
    ได้รับอนุญาตให้ลา 
<?= $leaveType->title ?>
<?php #$date_range_old ?> 
    รวม <span class="text-dashed"><?= $number_day ?></spa> วัน      นั้น
</p>

<p class="p-form-indent">เนื่องจาก <?= $reason ?>
    จึงขอยกเลิกวันลา 
    <span class="text-dashed"><?= $leaveType->title ?></span>
    จำนวน ……………วัน
<?= $date_range ?>
</p>



    <?php
#######################
    $col1 = 'col-sm-4 col-sm-offset-1';
    $col2 = 'col-sm-4 col-sm-offset-2';
    ?>
<div class="row">

    <div class="col-sm-12 text-center">

        <p>
            ลงชื่อ .....................................<br/>
            (<span class="text-dashed"><?= $user->fullname ?></span>)<br/>
            ตำแหน่ง <?= $user->position->title ?>
        </p>
    </div>
</div>


<div class="row">

    <div class="col-sm-10 col-sm-offset-1 text-center">

        <h4 class="text-left">ผู้บังคับบัญชา</h4>
        <p class="text-left">
<?= $commander['status'] ?><br/>
            ความคิดเห็น<br/>
            <span class="text-dashed width100"><?= $commander['comment'] ?></span>
        </p>

        <br/>
    </div>
</div>
<div class="row">

    <div class="col-sm-4 col-sm-offset-5 text-center">
        <p>
            ลงชื่อ .....................................<br/>
<?= $commander['name'] ?><br/>
<?= $commander['position'] ?><br/>				
<?= $commander['at'] ? $commander['at'] : 'วันที่............./............................/................ ' ?>
        </p>
    </div>
</div>



<div class="row">
    <div class="col-sm-10 col-sm-offset-1 text-center">

        <h4 class="text-left">คำสั่ง</h4>
        <p class="text-left">
<?= $director['status'] ?><br/>
            ความคิดเห็น<br/>
            <span class="text-dashed width100">
<?= $director['comment'] ?>
            </span>
        </p>

    </div>
</div>
<div class="row">

    <div class="col-sm-4 col-sm-offset-5 text-center">
        <p>
            ลงชื่อ  .....................................<br/>
<?= $director['name'] ?><br/>	
<?= $director['position'] ?><br/>	
<?= $director['at'] ? $director['at'] : 'วันที่............./............................/................ ' ?>
        </p>
    </div>
</div>