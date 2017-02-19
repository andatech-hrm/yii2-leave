<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model andahrm\leave\models\LeaveRelated */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leave Relateds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'title',
            'sections',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>
  
  
   
<div class="x_panel tile">
            <div class="x_title">
                 <?=Html::tag('h2',$model->getAttributeLabel('approver'))?>
              <div class="panel_toolbox">
                 <?= Html::a(Yii::t('andahrm', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
              </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                  <div class="col-sm-4">
                    <?=Html::tag('h4',$model->getAttributeLabel('inspectors'))?>
                  <?php Pjax::begin();    ?>   
                  <?= GridView::widget([
                        'dataProvider' => $inspectorProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                            'attribute' => 'user_id',
                            'value'=> 'user.fullname',
                             ]
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
                </div>
                <div class="col-sm-4">
                  <?=Html::tag('h4',$model->getAttributeLabel('commanders'))?>
                  <?php Pjax::begin(); ?>   
                  <?= GridView::widget([
                        'dataProvider' => $commanderProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                            'attribute' => 'user_id',
                            'value'=> 'user.fullname',
                             ]
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
                </div>
                <div class="col-sm-4">
                  <?=Html::tag('h4',$model->getAttributeLabel('directors'))?>
                  <?php Pjax::begin(); ?>   
                  <?= GridView::widget([
                        'dataProvider' => $directorProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                            'attribute' => 'user_id',
                            'value'=> 'user.fullname',
                             ]
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
                </div>
              </div>
          <div class="clearfix"></div>
        </div>
    </div>
  
<?php /* อาจารย์ให้ไปเลือกจาก section
<div class="x_panel tile">
            <div class="x_title">
                 <?=Html::tag('h2',$model->getAttributeLabel('persons'))?>
              <div class="panel_toolbox">
                 <?= Html::a(Yii::t('andahrm/leave', 'Assign'), ['assign', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
              </div>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
              
                  <?php Pjax::begin(); ?>   
                  <?= GridView::widget([
                        'dataProvider' => $personProvider,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                            'attribute' => 'user_id',
                            'value'=> 'user.fullname',
                             ]
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
                
          <div class="clearfix"></div>
        </div>
    </div>
*/?>