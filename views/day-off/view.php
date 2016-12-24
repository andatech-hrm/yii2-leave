<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveDayOff */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Day Offs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-day-off-view">

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
            'title',
            'date_start',
            'date_end',
            'detail',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
