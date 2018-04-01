<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveCancel;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\leave\models\LeaveInspactorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/leave', 'Leaves');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-index">
    
<?=Html::tag('h2','รายการพิจารณาการอนุมัติการลา');?>
<?php Pjax::begin(); ?>    
	<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'to',            
            [
              'attribute'=>'created_by',
              'value'=>'createdBy.fullname'
            ],
            [
							'attribute'=>'leave_type_id',
						 'value'=>'leaveType.title'
						],
            //'contact',
						 'date_start:date',
						[
							'attribute'=>'start_part',
						 	'value'=>'startPartLabel'
						],
            'date_end:date',
						[
							'attribute'=>'end_part',
						 	'value'=>'endPartLabel'
						],
						[
							'attribute'=>'status',
							'format'=>'html',
							'filter'=>Leave::getItemStatus(),
						 'value'=>'statusLabel'
						],
						[
							'attribute'=>'inspector_status',
							'format'=>'html',
							'filter'=>Leave::getItemInspactorStatus(),
						 'value'=>'inspactorStatusLabel'
						],
						

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{consider} {view}',
                'buttons' => [
                  'consider' => function($url,$model,$key){
                        return $model->inspector_status==null?Html::a('พิจารณา',$url,['class'=>'btn btn-primary btn-xs']):null;
                      }
                  ]
  
            ],
        ],
    ]); ?>
    
<?php Pjax::end(); ?>

<?=Html::tag('h2','รายการยกเลิกวัน');?>

<?php Pjax::begin(); ?>    
	<?= GridView::widget([
        'dataProvider' => $dataProviderCancel,
        'filterModel' => $searchModelCancel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            //'to',            
            [
              'attribute'=>'created_by',
              'value'=>'createdBy.fullname'
            ],
            [
							'attribute'=>'leave_type_id',
						 'value'=>'leaveType.title'
						],
            //'contact',
						 'date_start:date',
						[
							'attribute'=>'start_part',
						 	'value'=>'startPartLabel'
						],
            'date_end:date',
						[
							'attribute'=>'end_part',
						 	'value'=>'endPartLabel'
						],
						[
							'attribute'=>'status',
							'format'=>'html',
							'filter'=>Leave::getItemStatus(),
						 'value'=>'statusLabel'
						],
						

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{consider} {view}',
                //'url'=>Url::to(['cancel']),
                'buttons' => [
                  'consider' => function($url,$model,$key){
                        return $model->status?Html::a('พิจารณา',Url::to(['cancel-consider','id'=>$model->id]),['class'=>'btn btn-primary btn-xs']):null;
                      },
                  'view' => function($url,$model,$key){
                        return $model->status?Html::a('<span class="glyphicon glyphicon-eye-open"></span>',Url::to(['cancel-view','id'=>$model->id])):null;
                      }
                  ],
                  'urlCreator' => Url::to(['cancel']),
                        
  
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?>



</div>
