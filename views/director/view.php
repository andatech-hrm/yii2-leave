<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\Leave */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-view">

    <h1><?= Html::encode($this->title) ?></h1>
  
    <?= $this->render('../default/view-detail', [
        'model' => $model,
    ]) ?>

</div>
