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
  
    $model->persons = $model->personSelected;
    echo $form->field($model, 'persons')->widget(DualListbox::className(),[
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
