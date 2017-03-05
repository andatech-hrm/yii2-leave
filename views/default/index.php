<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveCancelSearch;
use yii\helpers\ArrayHelper;
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

<?php 
foreach($leaveType as $type):
if($type->data):
	if($type->id==Leave::TYPE_VACATION):
		// $searchModel1 = new LeaveCancelSearch();
  //      $dataProvider1 = $searchModel1->search(Yii::$app->request->queryParams);
		// $dataProvider1 = ArrayHelper::toArray($dataProvider1);
		// $dataProvider = ArrayHelper::merge($type->data,$dataProvider);
		#ลาพักผ่อน
	echo GridView::widget([
        'dataProvider' => $type->data,
        //'filterModel' => $searchModel,
        //ActionColumn
        'showFooter'=>true,
		'showPageSummary'=>true,
	    'pjax'=>true,
	    'striped'=>false,
	    'hover'=>true,
	    'panel'=>['type'=>'primary', 'heading'=>$type->title],
	    'columns'=>[
	        
			//'year',
   //         [
			// 	'class' => '\kartik\grid\CheckboxColumn',
			// 	'checkboxOptions' => function ($model, $key, $index, $column) {
			// 				return ['value' => $model->id,'disabled'=>$model->status!=0?true:false];
			// 		}
			// ],
			['class'=>'kartik\grid\SerialColumn'],
			
			[
			 'attribute'=>'id',
			 'format'=>'html',
			 'value'=>function($model){
			 	return Html::a('<i class="fa fa-book"></i> '.$model->id,['view','id'=>$model->id],['class'=>'btn btn-xs btn-link']);
			 },
			],
			[
			 'attribute'=>'date_range',
			 'format'=>'html',
			 'value'=>function($model){
			 	$str = $model->dateRange;
			 	return $str.$model->getLeaveCancelByField('dateRange');
			 },
			 
			 //'group'=>true,  // enable grouping
			 //'pageSummary'=>true,
			 'pageSummary'=>'รวม (วันลาพักผ่อน)',
			 'footer'=>'คงเหลือ (วันลาพักผ่อน)',
             //'pageSummaryOptions'=>['class'=>'text-right text-warning'],
			 
			],
            //'leave_type_id',
             //'date_start:date',
            //'start_part',
             //'date_end:date',
			[
				'attribute'=>'number_day',
				'format'=>'html',
				//'value'=>'number_day',
				'value'=>function($model){
				 	$str = Yii::$app->formatter->asDecimal($model->number_day,1);
				 	return $str.$model->getLeaveCancelNumber('number_day');
				 },
				'hAlign'=>'right',
			    //'format'=>['decimal', 1],
			    'groupedRow'=>true,  
			    'pageSummary'=>Leave::getPastDay(Yii::$app->user->id,$searchModel->year),
			    'footer' => Leave::getTotal(Yii::$app->user->id,$searchModel->year),
			],
			############################
			// 'reason:ntext',
			// 'acting_user_id',
			[
				'attribute'=>'inspector_status',
				'format'=>'html',
				'filter'=>Leave::getItemInspactorStatus(),
			    'value'=>'inspactorStatusLabel',
			  //  'value'=>function($model){
				 //	$str = $model->inspactorStatusLabel;
				 //	return $str.$model->getLeaveCancelByField('inspactorStatusLabel');
				 //},
			],
			[
				'attribute'=>'commander_status',
				'format'=>'html',
				'filter'=>Leave::getItemCommanderStatus(),
				//'value'=>'commanderStatusLabel',
				'value'=>function($model){
				 	$str = $model->commanderStatusLabel;
				 	return $str.$model->getLeaveCancelByField('commanderStatusLabel');
				 },
			],
			[
				'label'=> Yii::t('andahrm/leave', 'Directors'),
				'attribute'=>'director_status',
				'format'=>'html',
				'filter'=>Leave::getItemDirectorStatus(),
			 	//'value'=>'directorStatusLabel',
			 	'value'=>function($model){
				 	$str = $model->directorStatusLabel;
				 	return $str.$model->getLeaveCancelByField('directorStatusLabel');
				 },
			],
			
			[
				'attribute'=>'status',
				'format'=>'html',
				'filter'=>Leave::getItemStatus(),
				// 'value'=>'statusLabel'
				'value'=>function($model){
				 	$str = $model->statusLabel;
				 	return $str.$model->getLeaveCancelByField('statusLabel');
				 },
			],
			#########################			
            
			[
				'class' => 'kartik\grid\ActionColumn',
				'buttonOptions'=>['class'=>'btn btn-default'],
				//'template'=>'{cancel}{update}{delete}{view}{cancel-view}',
				'template'=>'{cancel}{update}{delete}{cancel-view}',
				'hAlign'=>'right',
				'headerOptions'=>[
				    'style'=>"width:10%"
				  ],
				'contentOptions'=>[
				    'noWrap' => true,
				    'style'=>"width:10%"
				  ],
				'buttons' => [
					'cancel' => function($url,$model,$key){
						if($model->numberDayTotal){
							return $model->status==Leave::STATUS_ALLOW?Html::a(Yii::t('andahrm/leave', 'Cancel leave'),$url,['class'=>'btn btn-xs btn-warning', 'data-pjax' => 0]):'';
						}
					},
					'update' => function($url,$model,$key){
						return ($model->status==Leave::STATUS_OFFER&&$model->commander_status==null)?Html::a('<span class="glyphicon glyphicon-pencil"></span>',$url,['class'=>'btn btn-xs btn-default', 'data-pjax' => 0]):'';
					},
					'delete' => function($url,$model,$key){
						return $model->status==Leave::STATUS_OFFER?Html::a('ลบ',$url,['class'=>'btn btn-xs btn-danger','data-method'=>'POST', 'data-pjax' => 0]):'';
					},
					'view' => function($url,$model,$key){
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',$url,['class'=>'btn btn-xs btn-default', 'data-pjax' => 0]);
					},
					'cancel-view' => function($url,$model,$key){
						return $model->leaveCancel?$model->leaveCancelButton:'';
					},
				]
			],
        ],
    ]); 
    ################ 2 ขึ้นไป 
    else:
    	echo GridView::widget([
        'dataProvider' => $type->data,
        //'filterModel' => $searchModel,
        //'showFooter'=>true,
		//'showPageSummary'=>true,
	    'pjax'=>true,
	    'striped'=>false,
	    'hover'=>true,
	    'panel'=>['type'=>'primary', 'heading'=>$type->title],
	    'columns'=>[
	        
			//'year',
   //         [
			// 	'class' => '\kartik\grid\CheckboxColumn',
			// 	'checkboxOptions' => function ($model, $key, $index, $column) {
			// 				return ['value' => $model->id,'disabled'=>$model->status!=0?true:false];
			// 		}
			// ],
			['class'=>'kartik\grid\SerialColumn'],
			[
			 'attribute'=>'id',
			 'format'=>'html',
			 'value'=>function($model){
			 	return Html::a('<i class="fa fa-book"></i> '.$model->id,['view','id'=>$model->id],['class'=>'btn btn-xs btn-link']);
			 },
			],
            //'user_id',
			// [
			//  'attribute'=>'leave_type_id',
			//  'value'=>'leaveType.title',
			//  'group'=>true,  // enable grouping
			//  'pageSummary'=>'Page Summary',
   //          'pageSummaryOptions'=>['class'=>'text-right text-warning'],
			//  'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
	  //              return [
	  //                  'mergeColumns'=>[[1,4]], // columns to merge in summary
	  //                  'content'=>[             // content to show in each summary cell
	  //                      1=>'Summary',
	  //                      //4=>GridView::F_AVG,
	  //                      5=>GridView::F_SUM,
	  //                      //6=>GridView::F_SUM,
	  //                  ],
	  //                  'contentFormats'=>[      // content reformatting for each summary cell
	  //                      5=>['format'=>'number', 'decimals'=>1],
	  //                  ],
	  //                  'contentOptions'=>[      // content html attributes for each summary cell
	  //                      //1=>['style'=>'font-variant:small-caps'],
	  //                      5=>['style'=>'text-align:right'],
	  //                  ],
	  //                  // html attributes for group summary row
	  //                  'options'=>['class'=>'default','style'=>'font-weight:bold;']
	  //              ];
	  //          }
			// ],
            [
			 'attribute'=>'date_range',
			 'format'=>'html',
			 'value'=>function($model){
			 	$str = $model->dateRange;
			 	return $str.$model->getLeaveCancelByField('dateRange');
			 },
			 
			 //'group'=>true,  // enable grouping
			 //'pageSummary'=>true,
			 'pageSummary'=>'รวม (วันลาพักผ่อน)',
			 'footer'=>'คงเหลือ (วันลาพักผ่อน)',
             //'pageSummaryOptions'=>['class'=>'text-right text-warning'],
			 
			],
			[
				'attribute'=>'number_day',
				'value'=>'number_day',
				'footer' => Leave::getPastDay(Yii::$app->user->id,$searchModel->year),
				'value'=>function($model){
				 	$str = Yii::$app->formatter->asDecimal($model->number_day,1);
				 	return $str.$model->getLeaveCancelNumber('number_day');
				 },
				'hAlign'=>'right',
			    //'format'=>['decimal', 1],
			    'pageSummary'=>true,
			    'pageSummaryFunc'=>GridView::F_AVG
			],
			############################
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
				'label'=> Yii::t('andahrm/leave', 'Directors'),
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
			#########################			
            
			[
				'class' => 'kartik\grid\ActionColumn',
				'buttonOptions'=>['class'=>'btn btn-default'],
				'template'=>'{cancel}{update}{delete}{cancel-view}',
				'hAlign'=>'right',
				'headerOptions'=>[
				    'style'=>"width:10%"
				  ],
				'contentOptions'=>[
				    'noWrap' => true,
				    'style'=>"width:10%"
				  ],
				'buttons' => [
					'cancel' => function($url,$model,$key){
						//return $model->numberDayTotal;
						if($model->numberDayTotal){
							return $model->status==Leave::STATUS_ALLOW?Html::a(Yii::t('andahrm/leave', 'Cancel leave'),$url,['class'=>'btn btn-xs btn-warning', 'data-pjax' => 0]):'';
						}
					},
					'update' => function($url,$model,$key){
						return ($model->status==Leave::STATUS_OFFER&&$model->commander_status==null)?Html::a('<span class="glyphicon glyphicon-pencil"></span>',$url,['class'=>'btn btn-xs btn-default', 'data-pjax' => 0]):'';
					},
					'delete' => function($url,$model,$key){
						return $model->status==Leave::STATUS_OFFER?Html::a('ลบ',$url,['class'=>'btn btn-xs btn-danger','data-method'=>'POST', 'data-pjax' => 0]):'';
					},
					'view' => function($url,$model,$key){
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',$url,['class'=>'btn btn-xs btn-default', 'data-pjax' => 0]);
					},
					'cancel-view' => function($url,$model,$key){
						return $model->leaveCancel?$model->leaveCancelButton:'';
					},
				]
			],
        ],
    ]); 
	endif;
endif;
endforeach;?>

</div>
