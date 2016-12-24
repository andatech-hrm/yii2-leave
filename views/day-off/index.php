<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\leave\models\LeaveDayOffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/leave', 'Leave Day Offs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-day-off-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('andahrm/leave', 'Create Leave Day Off'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'date_start',
            'date_end',
            'detail',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
