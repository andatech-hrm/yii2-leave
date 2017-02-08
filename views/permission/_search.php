<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\structure\models\FiscalYear;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="leave-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => ['data-pjax' => true ]
    ]); ?>
  
  
<div class="row">
  <div class="col-sm-3">
    <?= $form->field($model, 'year')->dropDownList(FiscalYear::getList(),[]) ?>
  </div>
  <div class="col-sm-3">
    <div class="form-group">
      <?= Html::submitButton(Yii::t('andahrm/leave', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('andahrm/leave', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>
  </div>

</div>

    

    <?php ActiveForm::end(); ?>

</div>
