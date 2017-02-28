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
    
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    
<?php Pjax::begin(); ?>   
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute'=> 'user_id',
                'format' => 'html',
                'value' => 'user.infoMedia'
            ],
            //'leave_condition_id',
            //'year',
             [
                'attribute'=>'number_day',
                'contentOptions' => ['class'=>'text-right'],
                'value' => function($model){
                    return $model->number_day." ".Yii::t('andahrm','Day');
                }
            ],
            'created_at:datetime',
            [
                'attribute'=>'created_by',
                'value' =>  'createdBy.fullname',
            ],
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn',
            'template'=>'{view}'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
