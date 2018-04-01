<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax; 
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use andahrm\structure\models\Position;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeavePermission */
/* @var $form yii\widgets\ActiveForm */
$data = $dataProvider->getModels();
$positionList = ArrayHelper::map($data,'positionSalary.position.id','positionSalary.position.code');
//print_r($positionList);

?>

<div class="leave-permission-form">

  <?php echo $this->render('_person_type', ['model' => $searchModel]); ?>
  
  
  <?php Pjax::begin(['id' => 'pjax_person']); ?>   
  
   
  
  <?php 
  $queryParams = Yii::$app->request->queryParams;
  if(isset($queryParams['PersonSearch']['person_type_id']) && $queryParams['PersonSearch']['year']):
  ?>
  <?php $form = ActiveForm::begin(); ?>  
   <?= $form->field($model, 'year')->hiddenInput(['value'=>$searchModel->year]) ?>
  <?php
  
   echo GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
              'attribute'=>'user_id',
              'value'=>'fullname'
            ],
            [
              //'label'=>'position',
              'attribute'=>'position_id',
              //'filter'=>$positionList,
              'value'=>'positionSalary.position.code'
            ],
           
            'leavePermissionByYear.year',
            //'leavePermission.number_day',
             [
              'label'=> Yii::t('andahrm/leave', 'Number Day'),      
              'format' => 'raw',
              'value'=>function($model,$key){  
                  $number_day = $model->leavePermissionByYear?$model->leavePermissionByYear->number_day:0;
                  return Html::textInput("LeavePermission[number_day][]", $number_day)
                    .Html::hiddenInput("LeavePermission[user_id][]", $model->user_id);
              }
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
  ?>
  <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
  <?php ActiveForm::end(); ?>
  <?php
  else:
    echo "กรุณาเลือกประเภทบุคคลและปีก่อน";  
  endif;
  ?>
  
   <?php Pjax::end(); ?>

    

</div>
