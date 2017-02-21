<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveCancel */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Cancels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-cancel-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm/leave', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm/leave', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm/leave', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'to',
            'leave_id',
            'reason',
            'date_start',
            'start_part',
            'date_end',
            'end_part',
            'number_day',
            'status',
            'commander_comment:ntext',
            'commander_status',
            'commander_by',
            'commander_at',
            'director_comment',
            'director_status',
            'director_by',
            'director_at',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
