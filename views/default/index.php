<?php

use yii\helpers\Html;
//use yii\grid\GridView;
use kartik\grid\GridView;
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

<?php 
foreach($leaveType as $type):
if($type->data):
	if($type->id==4):
	echo GridView::widget([
        'dataProvider' => $type->data,
        //'filterModel' => $searchModel,
        'showFooter'=>true,
		//'showPageSummary'=>true,
	    'pjax'=>true,
	    'striped'=>false,
	    'hover'=>true,
	    'panel'=>['type'=>'primary', 'heading'=>$type->title],
	    'columns'=>[
	        
			//'year',
            [
				'class' => '\kartik\grid\CheckboxColumn',
				'checkboxOptions' => function ($model, $key, $index, $column) {
							return ['value' => $model->id,'disabled'=>$model->status!=0?true:false];
					}
			],
			['class'=>'kartik\grid\SerialColumn'],
            //'id',
            //'user_id',
			[
			 'attribute'=>'date_start',
			 'format' => 'date',
			 //'value'=>'leaveType.title',
			 //'group'=>true,  // enable grouping
			 'pageSummary'=>true,
			 'pageSummary'=>'Page Summary',
             'pageSummaryOptions'=>['class'=>'text-right text-warning'],
             'groupedRow'=>true,  
			 'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
	                return [
	                    'mergeColumns'=>[[1,3]], // columns to merge in summary
	                    'content'=>[             // content to show in each summary cell
	                        1=>'Summary',
	                        //4=>GridView::F_AVG,
	                        4=>GridView::F_SUM,
	                        //6=>GridView::F_SUM,
	                    ],
	                    'contentFormats'=>[      // content reformatting for each summary cell
	                        5=>['format'=>'number', 'decimals'=>1],
	                    ],
	                    'contentOptions'=>[      // content html attributes for each summary cell
	                        //1=>['style'=>'font-variant:small-caps'],
	                        5=>['style'=>'text-align:right'],
	                    ],
	                    // html attributes for group summary row
	                    'options'=>['class'=>'danger','style'=>'font-weight:bold;']
	                ];
	            }
			],
            //'leave_type_id',
             //'date_start:date',
            //'start_part',
             'date_end:date',
			[
				'attribute'=>'number_day',
				'value'=>'number_day',
				'footer' => Leave::getPastDay(),
				'hAlign'=>'right',
			    'format'=>['decimal', 1],
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
			#########################			
            
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
    ]); 
    ################ 1-3
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
            [
				'class' => '\kartik\grid\CheckboxColumn',
				'checkboxOptions' => function ($model, $key, $index, $column) {
							return ['value' => $model->id,'disabled'=>$model->status!=0?true:false];
					}
			],
			['class'=>'kartik\grid\SerialColumn'],
            //'id',
            //'user_id',
			[
			 'attribute'=>'leave_type_id',
			 'value'=>'leaveType.title',
			 'group'=>true,  // enable grouping
			 'pageSummary'=>'Page Summary',
             'pageSummaryOptions'=>['class'=>'text-right text-warning'],
			 'groupFooter'=>function ($model, $key, $index, $widget) { // Closure method
	                return [
	                    'mergeColumns'=>[[1,4]], // columns to merge in summary
	                    'content'=>[             // content to show in each summary cell
	                        1=>'Summary',
	                        //4=>GridView::F_AVG,
	                        5=>GridView::F_SUM,
	                        //6=>GridView::F_SUM,
	                    ],
	                    'contentFormats'=>[      // content reformatting for each summary cell
	                        5=>['format'=>'number', 'decimals'=>1],
	                    ],
	                    'contentOptions'=>[      // content html attributes for each summary cell
	                        //1=>['style'=>'font-variant:small-caps'],
	                        5=>['style'=>'text-align:right'],
	                    ],
	                    // html attributes for group summary row
	                    'options'=>['class'=>'default','style'=>'font-weight:bold;']
	                ];
	            }
			],
            //'leave_type_id',
             'date_start:date',
            //'start_part',
             'date_end:date',
             //number_day',
			[
				'attribute'=>'number_day',
				'value'=>'number_day',
				'footer' => Leave::getPastDay(),
				'hAlign'=>'right',
			    'format'=>['decimal', 1],
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
			#########################			
            
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
    ]); 
	endif;
endif;
endforeach;?>

</div>
