<?php

use andahrm\leave\models\PersonLeave;
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\LeavePermission;
use andahrm\leave\models\LeavePermissionTransection;

#ผู้ขอ
$user = PersonLeave::findOne($user_id);

#ผู้แทน
$actingUser = PersonLeave::findOne($model->acting_user_id);

#ข้อมูลประเภทการลา
$leaveType = LeaveType::findOne($model->leave_type_id);

#ข้อมูลโควต้า
$permisTrans = LeavePermissionTransection::getAmountOnType($user_id, $model->year);

#ผู้บังคับบัญชา
$commanderBy = PersonLeave::findOne($model->commander_by);
$commander['status'] = Leave::getWidgetStatus($model->commander_status, Leave::getItemCommanderStatus());
$commander['name'] = '(<span class="text-dashed">' . $commanderBy->fullname . '</span>)';
$commander['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $commanderBy->positionTitle . '</span>';
$commander['comment'] = $model->commander_comment ? $model->commander_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$commander['at'] = $model->commander_at ? $model->commanderAt : '';
//$items['commander'] = $commander ; 
#ผู้ตรวจสอบ
$inspectorBy = PersonLeave::findOne($model->inspector_by);
$inspector['status'] = Leave::getWidgetStatus($model->inspector_status, Leave::getItemInspactorStatus());
$inspector['name'] = '(<span class="text-dashed">' . $inspectorBy->fullname . '</span>)';
$inspector['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $inspectorBy->positionTitle . '</span>';
$inspector['comment'] = $model->inspector_comment ? $model->inspector_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$inspector['at'] = $model->inspector_at ? $model->inspectorAt : '';
// //$items['inspector'] = $inspector ; 
#ผู้ออกคำสั่ง 
$directorBy = PersonLeave::findOne($model->director_by);
$director['status'] = Leave::getWidgetStatus($model->director_status, Leave::getItemDirectorStatus());
$director['name'] = '(<span class="text-dashed">' . $directorBy->fullname . '</span>)';
$director['position'] = Yii::t('andahrm/position-salary', 'Position') . ' <span class="text-dashed">' . $directorBy->positionTitle . '</span>';
$director['comment'] = $model->director_comment ? $model->director_comment : '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
$director['at'] = $model->director_at ? $model->directorAt : '';
//$items['director'] = $director ; 
//print_r($commander);
?>

<div class="font-thai-sarabun">

    <h2 class="text-center">ใบลาพักผ่อน</h2>

    <p class="text-right">
        เขียนที่ <span class="text-dest-under">องค์การบริหารส่วนจังหวัดยะลา</span>
    </p>

    <p class="text-right">
        <?= $created_at ?>
    </p>



    <p class="text-left">
        เรื่อง <span class="text-dashed">ขอลาพักผ่อน</span>
    </p>

    <p class="text-left">
    <div class="row">
        <div class="col-sm-5">
            <?= $to ?>
        </div>
    </div>
</p>

<br/>

<p class="p-form-indent">

    ข้าพเจ้า <span class="text-dashed"><?= $user->fullname ?></span>
    ตำแหน่ง <span class="text-dashed"><?= $user->position->title ?></span>
    สังกัด <span class="text-dashed"><?= $user->position->section->title ?></span>
    วันลาพักผ่อนสะสม <span class="text-dashed"><?= $permisTrans[LeavePermissionTransection::TYPE_CARRY] ?></span> วัน 
    มีสิทธิลาพักผ่อนประจำปีนี้อีก 
    <span class="text-dashed">
        <?= $permisTrans[LeavePermissionTransection::TYPE_ADD] ?>
    </span> 
    วันทำการ
    รวมเป็น
    <span class="text-dashed">
        <?= $permisTrans[LeavePermissionTransection::TYPE_ADD] + $permisTrans[LeavePermissionTransection::TYPE_CARRY] ?>
    </span> 
    วันทำการ ขอลาพักผ่อน
    <?= (isset($date_range_input) ? "<br/>" . $date_range_input . "<br/>" : 'ตั้งแต่วันที่' . $date_range) ?>
    มีกำหนด<span class="text-dashed"> <?= $number_day ?> </span>วัน ในระหว่างลาจะติดต่อข้าพเจ้าได้ที่
    <?= $contact ?>

</p>

<?= (isset($acting_user_id) ? $acting_user_id : '') ?>

<p class="p-form-indent">
    ในการลาครั้งนี้ ข้าพเจ้าได้มอบหมายงานในหน้าที่ให้ 
    <span class="text-dashed"> <?= $actingUser->fullname ?> </span>
    เป็นผู้ปฎิบัติราชการแทน
</p>

<br/>
<br/>
<?php
$col1 = 'col-sm-4 col-sm-offset-1';
$col2 = 'col-sm-4 col-sm-offset-2';
?>
<div class="row">
    <div class="<?= $col1 ?> text-center">
        <p>
            ลงชื่อ ...................................ผู้รับมอบ<br/>
            (<span class="text-dashed"><?= $actingUser->fullname ?></span>)<br/>
            <?= Yii::t('andahrm/position-salary', 'Position') ?><span class="text-dashed"> <?= $actingUser->positionTitle ?></span>
        </p>
    </div>
    <div class="<?= $col2 ?> text-center">

        <p>
            ลงชื่อ .....................................<br/>
            (<span class="text-dashed"><?= $user->fullname ?></span>)<br/>
            <?= Yii::t('andahrm/position-salary', 'Position') ?><span class="text-dashed"> <?= $user->positionTitle ?></span>
        </p>
    </div>
</div>
<br/>
<br/>


<div class="row">
    <div class="<?= $col1 ?> text-center">
        <h4 class="text-center">
            สถิติการลาในปีงบประมาณนี้
        </h4> 
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-center">ลามาแล้ว<br/>(วันทำการ)</th>
                    <th class="text-center">ลาครั้งนี้<br/>(วันทำการ)</th>
                    <th class="text-center">รวมเป็น<br/>(วันทำการ)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $pastDay ?></td>
                    <td><?= $number_day ?></td>
                    <td><?= $pastDay + $number_day ?></td>
                </tr>
            </tbody>
        </table>



    </div>
    <div class="<?= $col2 ?> text-center">

        <h4 class="text-left">ผู้บังคับบัญชา</h4>
        <p class="text-left">
            <?= $commander['status'] ?><br/>
            ความคิดเห็น<br/>
            <span class="text-dashed width100"><?= $commander['comment'] ?></span>
        </p>
        <?= isset($commander_input) ? $commander_input : '' ?>
        <p>
            ลงชื่อ .....................................<br/>
            <?= $commander['name'] ?><br/>
            <?= $commander['position'] ?><br/>				
            <?= $commander['at'] ? $commander['at'] : 'วันที่............./............................/................ ' ?>
        </p>
        <br/>
    </div>
</div>



<div class="row">
    <div class="<?= $col1 ?> text-center">
        <h4 class="text-left">ผู้ตรวจสอบ</h4>
        <p class="text-left">
            <?= $inspector['status'] ?>
            <br/>
            ความคิดเห็น<br/>
            <span class="text-dashed width100">
                <?= $inspector['comment'] ?>
            </span>
        </p>
        <?= isset($inspector_input) ? $inspector_input : '' ?>
        <p>
            ลงชื่อ .....................................<br/>

            <?= $inspector['name'] ?><br/>
            <?= $inspector['position'] ?><br/>	
            <?= $inspector['at'] ? $inspector['at'] : 'วันที่............./............................/................ ' ?>
        </p>
    </div>

    <div class="<?= $col2 ?> text-center">
        <h4 class="text-left">คำสั่ง</h4>
        <p class="text-left">
            <?= $director['status'] ?><br/>
            ความคิดเห็น<br/>
            <span class="text-dashed width100">
                <?= $director['comment'] ?>
            </span>
        </p>
        <?= isset($director_input) ? $director_input : '' ?>
        <p>
            ลงชื่อ  .....................................<br/>
            <?= $director['name'] ?><br/>	
            <?= $director['position'] ?><br/>	
            <?= $director['at'] ? $director['at'] : 'วันที่............./............................/................ ' ?>
        </p>
    </div>
</div>

</div>