<?php

use yii\helpers\Html;
?>

<div class="font-thai-sarabun">   



<!--    <p class="text-left">
        เรื่อง <span class="text-dashed">ขอยกเลิกวันลา</span>
    </p>-->


    <div class="row">
        <div class="col-sm-5">
            <?= $to ?>
        </div>
    </div>

    <p class="p-form-indent">

        ข้าพเจ้า <span class="text-dashed"><?= $user->fullname ?></span>
        ตำแหน่ง <span class="text-dashed"><?= $user->position->title ?></span>
        สังกัด <span class="text-dashed"><?= $user->position->section->title ?></span>
        ได้รับอนุญาตให้ลา 
        <?= $leaveType->title ?>
        <?php #$date_range_old   ?> 
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




    <hr/>
    <?= Html::tag('h4', Yii::t('andahrm/leave', 'Leave Relateds')) ?>
    <div class="row">

        <div class="col-sm-6">
            <?= $commanders ?>
        </div>

        <div class="col-sm-6">
            <?= $directors ?>
        </div>
    </div>
</div>