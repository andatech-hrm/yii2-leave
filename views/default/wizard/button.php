<?php
use yii\helpers\Html;


$step = $event->step;
$finish= $event->sender->getStepCount()-1;
$steps= $event->sender->getSteps();
$step_index = array_search($step,$steps);
?>

<hr />
<div class="row">
    <div class="col-sm-12">
<?php

echo Html::beginTag('div', ['class' => 'btn-toolbar','role'=>'toolbar']);

    echo Html::beginTag('div', ['class' => 'btn-group pull-left','role'=>'group']);
         echo Html::a('<i class="fa fa-times"></i> '.Yii::t('andahrm', 'Reset'),['create','step'=>'reset'], ['class' => 'btn btn-link', 'name' => 'cancel', 'value' => 'pause']);
     echo Html::endTag('div');
    
    
     echo Html::beginTag('div', ['class' => 'btn-group pull-right','role'=>'group']);
         if($step_index >0){
            echo Html::submitButton('<i class="fa fa-pause"></i>  '.Yii::t('andahrm', 'Pause'), ['class' => 'btn btn-default', 'name' => 'pause', 'value' => 'pause']);
         }
         echo Html::submitButton('<i class="fa fa-times"></i> '.Yii::t('andahrm', 'Cancel'), ['class' => 'btn btn-default', 'name' => 'cancel', 'value' => 'pause']);
     echo Html::endTag('div');
    
    
//     if ($event->n === 0) {
//     echo Html::submitButton('Add Another', ['class' => 'btn btn-default', 'name' => 'add', 'value' => 'add']);
// }
    
    echo Html::beginTag('div', ['class' => 'btn-group pull-right','role'=>'group']);
        //if($step_index>0){
            echo Html::submitButton('<i class="fa fa-arrow-left "></i> '.Yii::t('andahrm', 'Prev'), ['class' => 'btn btn-primary', 'name' => 'prev', 'value' => 'prev' ]);
        //}
        //else{
       //     echo Html::submitButton('<i class="fa fa-arrow-left "></i> Prev'.Yii::t('andahrm', 'Pause'), ['class' => 'btn btn-default', 'name' => 'prev', 'value' => 'prev','disabled'=>'disabled' ]);
       // }
        
        if($finish>$step_index){
            echo Html::submitButton(Yii::t('andahrm', 'Next').' <i class="fa fa-arrow-right "></i>', ['class' => 'btn btn-success', 'name' => 'next', 'value' => 'next']);
        }else{
            echo Html::submitButton('<i class="fa fa-flag-checkered"></i> '.Yii::t('andahrm', 'Confirm'), ['class' => 'btn btn-success', 'name' => 'next', 'value' => 'next']);
            //echo Html::submitButton('<i class="fa fa-flag-checkered"></i> '.Yii::t('andahrm', 'Done'), ['class' => 'btn btn-success', 'name' => 'next', 'value' => 'next']);
        }
    echo Html::endTag('div');
    
    
    
echo Html::endTag('div');
?>

</div>
</div>

<?php
//echo $event->sender;


// echo "<pre>";
// // print_r($event->sender-wizard->steps);
// // print_r($event->sender->getStepCount());
// echo $event->n."<br/>";
// echo $event->t."<br/>";
// echo $event->nextStep."<br/>";
// echo $event->continue."<br/>";
// echo "</pre>";
// ?>