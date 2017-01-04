<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveCondition */

$this->title = Yii::t('andahrm/leave', 'Create Leave Condition');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Conditions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-condition-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
