<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveRelated */

$this->title = Yii::t('andahrm/leave', 'Create Leave Related');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Relateds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-related-create">
    <?= $this->render('_form', [
        'model' => $model,
            'modelSection'=>$modelSection
    ]) ?>
</div>
