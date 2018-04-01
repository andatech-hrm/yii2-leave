<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveDayOff */

$this->title = Yii::t('andahrm/leave', 'Create Leave Day Off');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Day Offs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-day-off-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
