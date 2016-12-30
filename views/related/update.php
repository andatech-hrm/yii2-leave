<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveRelated */

$this->title = Yii::t('andahrm/leave', 'Update {modelClass}: ', [
    'modelClass' => 'Leave Related',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Relateds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/leave', 'Update');
?>
<div class="leave-related-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
