<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\leave\models\LeavePermissionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/leave', 'Leave Permissions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-permission-index">

    <p>
        <?= Html::a(Yii::t('andahrm/leave', 'Manage Leave Permission'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php #echo $this->render('_search', ['model' => $searchModel]);  ?>


    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'fullname',
                'format' => 'html',
                'value' => 'infoMedia'
            ],
            //'leave_condition_id',
            //'year',
            [
                'attribute' => 'leavePermission.number_day',
                'contentOptions' => ['class' => 'text-right'],
                'value' => function($model) {
                    return !$model->leavePermission ?: $model->leavePermission->number_day . " " . Yii::t('andahrm', 'Day');
                }
            ],
            'created_at:datetime',
            [
                'attribute' => 'created_by',
                'value' => 'createdBy.fullname',
            ],
            [
                'format' => 'html',
                'value' => function($model) {
                    return Html::a(Yii::t('andahrm/leave', 'Management'), ['manage', 'id' => $model->user_id], ['class' => 'btn btn-primary']);
                }
            ]
        // 'updated_at',
        // 'updated_by',
//            ['class' => 'yii\grid\ActionColumn',
//                'template' => '{view}'],
        ],
    ]);
    ?>
</div>
