<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\leave\models\LeaveRelatedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/leave', 'Leave Relateds');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-related-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('andahrm/leave', 'Create Leave Related'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            [
                'attribute' => 'inspector_by',
                'value' => function($model){
                return  $model->inspectorBy->fullname;
              }
            ],
            [
                'attribute' => 'commander_by',
                'value' => function($model){
                return  $model->commanderBy->fullname;
              }
            ],
            [
                'attribute' => 'director_by',
                'value' => function($model){
                return  $model->directorBy->fullname;
              }
            ],
            [
                'label' => 'จำนวนผู้เกี่ยวข้อง',
                'value' => function($model){
                return  count($model->leaveRelatedPeople);
              }
            ],
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
