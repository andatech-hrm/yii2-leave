<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeavePermission */

$this->title = Yii::t('andahrm', 'Update {modelClass}: ', [
    'modelClass' => 'Leave Permission',
]) . $model->user_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'user_id' => $model->user_id, 'leave_condition_id' => $model->leave_condition_id, 'year' => $model->year]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>
<div class="leave-permission-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
