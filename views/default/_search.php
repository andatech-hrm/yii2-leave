<?php

use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use yii\bootstrap\ActiveForm;
use andahrm\structure\models\FiscalYear;
use andahrm\leave\models\Leave;
use andahrm\leave\models\LeavePermission;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true ],
        'layout' => 'horizontal',
        'fieldConfig' => [
        'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
        'horizontalCssClasses' => [
            'label' => 'col-sm-5',
            'offset' => 'col-sm-offset-2',
            'wrapper' => 'col-sm-7',
            'error' => '',
            'hint' => '',
        ],
    ],
    ]); ?>
  
    <div class="row">
        
      <div class="col-sm-3 pull-right">
        <?= $form->field($model, 'year')->dropDownList(FiscalYear::getList(),['onchange'=>'this.form.submit()']) ?>
      </div>
      
       <div class="col-xs-12 col-sm-4">
<?= Html::a('<i class="fa fa-edit"></i><br/>'.Yii::t('andahrm/leave', 'แบบฟอร์มการลา'), ['create'], ['class' => 'btn btn-success btn-blocks']) ?>
    </div>
      
      <!--<div class="col-sm-3">-->
      <!--  <div class="form-group">-->
      <!--    <?= Html::submitButton(Yii::t('andahrm', 'Search'), ['class' => 'btn btn-primary']) ?>-->
      <!--  </div>-->
      <!--</div>-->
    
    </div>

    <?php ActiveForm::end(); ?>
    
     <div class="row">
      <div class="col-sm-6 pull-right text-right">
        <!--วันลาพักผ่อนสะสมประจำปี -->
        <?=Html::beginTag('label')?>
        <?=Yii::t('andahrm/leave','Accumulated annual vacation {year} : {number_day} days',[
            'year'=>FiscalYear::findOne(['year'=>$model->year])->yearTh,
            'number_day' => LeavePermission::getPermissionAll(Yii::$app->user->id,$model->year)
        ])?>  
        <?=Html::endTag('label')?>
      </div>
    
    </div>

</div>
