<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveRelatedPerson */

$this->title = Yii::t('andahrm/leave', 'Create Leave Related Person');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Related People'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-related-person-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
