<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\leave\models\LeaveDayOffSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/leave', 'Leave Day Offs');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-day-off-index">
   <p>
        <?= Html::a(Yii::t('andahrm/leave', 'Create Leave Day Off'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
  
  
<?php Pjax::begin(); ?>   
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'date_start:date',
            'date_end:date',
            'detail',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
