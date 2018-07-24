<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeavePermission */
?>
<div class="leave-permission-view">

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' => 'user_id',
                'format' => 'html',
                'value' => $model->infoMedia
            ],
            [
                'attribute' => 'leavePermission.credit',
//                'value'=>function($model){
//        
//                }
            ]
        ],
    ])
    ?>

</div>


