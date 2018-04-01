<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveType */

$this->title = Yii::t('andahrm', 'Update {modelClass}: ', [
    'modelClass' => 'Leave Type',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Leave Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>
<div class="leave-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
