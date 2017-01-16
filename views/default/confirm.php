<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use andahrm\leave\models\Leave;
use andahrm\leave\models\LeaveDayOff;

use andahrm\person\models\Person;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Confirm Leave Vacation');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

# Candidate
$items=[];
$items['user'] = Person::findOne(Yii::$app->user->identity->id);
?>

<div class="leave-form">

    <?php $form = ActiveForm::begin();
  
  $items['user_id']=$model->user_id; 
  
  $items['leave_type_id']=$model->leave_type_id;
 
  $items['date_range']= $model->date_start.' ถึง '.$model->date_end;
  
  $items['start_part']=$model->start_part;
  
  $items['end_part']=$model->end_part;
  
  $items['reason']=$model->reason;
  
  $items['acting_user_id'] = $model->acting_user_id;
  
  
  ?>
  
  
  

    <?=$this->render('template-'.(($model->leave_type_id==4)?'vacation':'sick'),$items)?>
  

    <div class="form-group">
        <?= Html::a(Yii::t('andahrm/leave', 'Update'),['update','id'=>$model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::submitButton(Yii::t('andahrm/leave', 'Confirm'), ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

