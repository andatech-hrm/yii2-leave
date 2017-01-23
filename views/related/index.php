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

    <h1><?= Html::encode($this->title) ?></h1>
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
              'attribute' => 'persons',
              'value' => function($model){
                return count($model->leaveRelatedPeople).' คน';
              }
            ],
            'updated_at:datetime',
            'updated_by',

           //['class' => 'yii\grid\ActionColumn'],
   [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{assign} {view} {update} {delete}',
                'buttons' => [
                    'assign' => function ($url, $model, $key) {
                        return Html::a('<i class="fa fa-user-plus"></i>',['related/assign', 'id' => $model->id], [
                                    'title' => Yii::t('andahrm/leave', 'Assign'),
                                    'data-pjax' => '0',
                        ]);
                    },
                ]
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
