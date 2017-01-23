<?php

use yii\helpers\Html;

use softark\duallistbox\DualListbox;
use andahrm\person\models\Person;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveRelatedApprover */
/* @var $form ActiveForm */
?>
<div class="releave-related">
  
  <?php
    $options = [
        'multiple' => true,
        'size' => 20,
    ];
  
    $model->inspectors = $model->inspectorSelected;
    echo $form->field($model, 'inspectors')->widget(DualListbox::className(),[
        'items' => Person::getList(),
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Items',
            'nonSelectedListLabel' => 'Available Items',
        ],
    ]);
  
  $model->commanders = $model->commanderSelected;
    echo $form->field($model, 'commanders')->widget(DualListbox::className(),[
        'items' => Person::getList(),
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Items',
            'nonSelectedListLabel' => 'Available Items',
        ],
    ]);

  
  $model->directors = $model->directorSelected;
    echo $form->field($model, 'directors')->widget(DualListbox::className(),[
        'items' => Person::getList(),
        'options' => $options,
        'clientOptions' => [
            'moveOnSelect' => false,
            'selectedListLabel' => 'Selected Items',
            'nonSelectedListLabel' => 'Available Items',
        ],
    ]);
  
  ?>

</div><!-- releave-related -->
