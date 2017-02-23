<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\leave\models\LeaveConditionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/leave', 'Leave Conditions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-condition-index">
   
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('andahrm/leave', 'Create Leave Condition'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            //'leave_type_id',
            [
                'attribute'=>'gov_service_status',
                'value' =>  'govStatusLabel',
            ],
            'number_year',
            // 'per_annual_leave',
            // 'per_annual_leave_limit',
            // 'status',
            'created_at:datetime',
            [
                'attribute'=>'created_by',
                'value' =>  'createdBy.fullname',
            ],
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
