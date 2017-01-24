<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use andahrm\leave\models\Leave;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\leave\models\LeaveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/leave', 'Leaves');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-index">
  
    

     <?php echo $this->render('intro'); ?>
    <hr/>
  

<?php  echo $this->render('_search', ['model' => $searchModel]); ?>

<?php Pjax::begin(); ?>    
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
				'showFooter' =>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
								'class' => 'yii\grid\CheckboxColumn',
								'checkboxOptions' => function ($model, $key, $index, $column) {
											return ['value' => $model->id,'disabled'=>$model->status!=0?true:false];
									}
						],
            //'id',
            //'user_id',
						[
							'attribute'=>'leave_type_id',
						 'value'=>'leaveType.title'
						],
            //'leave_type_id',
             'date_start:date',
            //'start_part',
             'date_end:date',
             'number_day',
						[
							'attribute'=>'number_day',
							'value'=>'number_day',
							'footer' => count($dataProvider->getModels())
						],
            // 'reason:ntext',
            // 'acting_user_id',
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
							'attribute'=>'status',
							'format'=>'html',
							'filter'=>Leave::getItemStatus(),
						 'value'=>'statusLabel'
						],
						
            // 'inspector_comment',
            // 'inspector_status',
            // 'inspector_by',
            // 'inspector_at',
            // 'commander_comment',
            // 'commander_status',
            // 'commander_by',
            // 'commanded_at',
            // 'director_comment',
            // 'director_status',
            // 'director_by',
            // 'director_at',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',
            [
								'class' => 'yii\grid\ActionColumn',
								'template'=>'{update} {view}',
								'buttons' => [
											'update' => function($url,$model,$key){
                        return $model->status==0?Html::a('<span class="glyphicon glyphicon-pencil"></span>',$url):'';
                      },
											'view' => function($url,$model,$key){
                        return $model->status!=0?Html::a('<span class="glyphicon glyphicon-eye-open"></span>',$url):'';
                      },
										]
						],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
