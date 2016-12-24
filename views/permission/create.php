<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeavePermission */

$this->title = Yii::t('andahrm/leave', 'Create Leave Permission');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-permission-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
