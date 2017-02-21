<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveCancel */

$this->title = Yii::t('andahrm/leave', 'Update {modelClass}: ', [
    'modelClass' => 'Leave Cancel',
]) . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Cancels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/leave', 'Update');
?>
<div class="leave-cancel-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
