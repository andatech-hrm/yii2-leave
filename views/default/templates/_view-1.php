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
    วันลาพักผ่อนสะสม <span class="text-dashed"><?= $collect ?></span> วัน 
    มีสิทธิลาพักผ่อนประจำปีนี้อีก 
    <span class="text-dashed">
        <?= $yearly ?>
    </span> 
    วันทำการ
    รวมเป็น
    <span class="text-dashed">
        <?= $total ?>
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
$col2 = 'col-sm-2';
$col3 = 'col-sm-4';
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
        &nbsp;
    </div>
    <div class="<?= $col3 ?> text-center">
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
        &nbsp;
    </div>
    <div class="<?= $col3 ?> text-center">
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

        <br/>
    </div>
</div>



<div class="row">
    <div class="<?= $col1 ?> text-center">
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
    </div>
    <div class="<?= $col2 ?> text-center">
        &nbsp;
    </div>
    <div class="<?= $col3 ?> text-center">
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