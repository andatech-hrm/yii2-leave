<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use andahrm\leave\models\Leave;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\leave\models\LeaveDirectorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/leave', 'Leaves');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-index">
    
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
							'attribute'=>'commander_status',
							'format'=>'html',
							'filter'=>Leave::getItemCommanderStatus(),
						 'value'=>'commanderStatusLabel'
						],
						[
							'label'=> Yii::t('andahrm/leave', 'ผู้ออกคำสั่ง'),
							'attribute'=>'director_status',
							'format'=>'html',
							'filter'=>Leave::getItemDirectorStatus(),
						 	'value'=>'directorStatusLabel'
						],
						

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{consider} {view}',
                'buttons' => [
                  'consider' => function($url,$model,$key){
                        return $model->director_status==null?Html::a('พิจารณา',$url,['class'=>'btn btn-primary btn-xs']):null;
                      }
                  ]
  
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
