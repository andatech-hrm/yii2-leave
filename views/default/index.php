<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\leave\models\LeaveSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/leave', 'Leaves');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="leave-index">
  
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div class="row">
      <div class="col-xs-12 col-sm-4">
          <?= Html::a('<i class="fa fa-edit"></i><br/>'.Yii::t('andahrm/leave', 'แบบฟอร์มขอลาป่วย ลากิจส่วนตัว และลาคลอด'), ['create-sick'], ['class' => 'btn btn-success btn-block']) ?>
      </div>
       <div class="col-xs-12 col-sm-8">
         <font size="2" color="#990000"><b>ลาป่วย และลากิจส่วนตัว<font color="#0000FF"> ( Sick Leave and Business Leave )</font></b></font><br/>
				<font size="2" color="#990000"> - ลาได้ไม่เกิน 9 ครั้ง (ภายในครึ่งปีงบประมาณ) <font color="#0000FF"> (Not more than 9 times (With in the first half of the fiscal year))</font></font><br/>
         <font size="2" color="#990000"> - ลาได้ไม่เกิน 23 วัน (ภายในครึ่งปีงบประมาณ)  <font color="#0000FF"> (Not more than 23 days (With in the first half of the fiscal year))</font></font>
       </div>
    </div>
  <hr/>
  <div class="row">
      <div class="col-xs-12 col-sm-4">
          <?= Html::a('<i class="fa fa-edit"></i><br/>'.Yii::t('andahrm/leave', 'แบบฟอร์มขอลาพักผ่อน'), ['create-vacation'], ['class' => 'btn btn-success btn-block']) ?>
      </div>
       <div class="col-xs-12 col-sm-8">
        <font size="2" color="#990000"><b>ลาพักผ่อน <font color="#0000FF">( Vacation Leave )</font></b></font><br/>
         <font size="2" color="#990000"> - ลาได้ไม่เกิน จำนวนวันลาพักผ่อนสะสม <font color="#0000FF">(Not permitted in excess of total currently accumulated vacation Leave)</font></font><br/>
         <font size="2" color="#990000"> - ไม่อนุญาตให้ลา กรณีที่อายุการทำงานไม่ถึง 6 เดือน   <font color="#0000FF">(Denied  if working duration is less than 6 months)</font></font></td>
				
       </div>
    </div>
    <hr/>
  
<?php Pjax::begin(); ?>    
  <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id',
            'leave_type_id',
            'date_start',
            'start_part',
            // 'date_end',
            // 'end_part',
            // 'reason:ntext',
            // 'acting_user_id',
            // 'status',
            // 'inspector_comment',
            // 'inspector_status',
            // 'inspector_by',
            // 'inspector_at',
            // 'commander_comment',
            // 'commander_status',
            // 'commander_by',
            // 'commanded_at',
            // 'director_comment',
            // 'director_status',
            // 'director_by',
            // 'director_at',
            // 'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
