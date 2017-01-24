<?php

use yii\helpers\Html;

use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = Yii::t('andahrm/leave', 'Update {modelClass}: ', [
    'modelClass' => 'Leave',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/leave', 'Update');
?>
<div class="leave-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('../default/view-detail', [
        'model' => $model,
    ]) ?>
  
    <?php $form = ActiveForm::begin();
  echo $form->field($model, 'status')->hiddenInput()->label(false)->hint(false);
      ?>
  
      <?=$form->field($model, 'director_comment')->textInput(['maxlength' => true]) ?>
  
      <div class="form-group">
        
        <?= Html::submitButton(Yii::t('andahrm/leave', 'Allow'), ['class' => 'btn btn-primary','name'=>'allow']) ?>
        <?= Html::submitButton(Yii::t('andahrm/leave', 'Disallow'), ['class' => 'btn btn-danger','name'=>'disallow']) ?>
        <?= Html::a(Yii::t('andahrm/leave', 'back'),['index'], ['class' => 'btn btn-link']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
