<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use andahrm\person\models\Person;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = $model->leaveType->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="hidden-print">     
    <div class="pull-left">
        <?=
        Html::a(Yii::t('andahrm', 'Cancel'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </div>
    <div class="pull-right">
        <?= Html::button('<i class="fa fa-print"></i>', ['class' => 'btn btn-default', 'onclick' => 'window.print();']) ?>
    </div>
</div>




<?=
$this->render('view-detail', [
    'model' => $model,
])
?>
