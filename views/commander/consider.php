<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Consider {leave_type} number: ', [
    'leave_type' => $model->leaveType->title,
]) . $model->id;

$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Commander'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-update">

    <h2><?= Html::encode($this->title) ?></h2>
    <hr/>

    <?= $this->render('../default/view-detail', [
        'model' => $model,
    ]) ?>
  
  
    <?php $form = ActiveForm::begin();
  echo $form->field($model, 'status')->hiddenInput()->label(false)->hint(false);
  echo $form->field($model, 'date_start')->hiddenInput()->label(false)->hint(false);
  echo $form->field($model, 'date_end')->hiddenInput()->label(false)->hint(false);
      ?>
  
      <?=$form->field($model, 'commander_comment')->textInput(['maxlength' => true]) ?>
      <div class="form-group">
        
        <?= Html::submitButton(Yii::t('andahrm/leave', 'Allow'), ['class' => 'btn btn-primary','name'=>'allow']) ?>
        <?= Html::submitButton(Yii::t('andahrm/leave', 'Disallow'), ['class' => 'btn btn-danger','name'=>'disallow']) ?>
        <?= Html::a(Yii::t('andahrm/leave', 'back'),['index'], ['class' => 'btn btn-link']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
