<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\structure\models\PersonType;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeavePermissionSearch */
/* @var $form yii\widgets\ActiveForm */
$startYear = 2000;
$endYear = date('Y');
$rangeYear = array_combine(range($startYear,$endYear),range($startYear+543,$endYear+543));
?>


    <?php $form = ActiveForm::begin([
        'method' => 'get',
        'options' => ['data-pjax' => true ]
    ]); ?>

   <div class="row">
    <div class="col-sm-8">      
      <?= $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(),[
        'prompt'=>'เลือก',
        'onchange' => 'this.form.submit()'
    ]) ?>  
    </div>
    <div class="col-sm-4">      
      <?= $form->field($model, 'year')->dropDownList($rangeYear,[
        'prompt'=>'เลือก',
        'onchange' => 'this.form.submit()'
    ]) ?>  
    </div>
  </div>

    <?php ActiveForm::end(); ?>

</div>
