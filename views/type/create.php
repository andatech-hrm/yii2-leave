<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveType */

$this->title = Yii::t('andahrm/leave', 'Create Leave Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
