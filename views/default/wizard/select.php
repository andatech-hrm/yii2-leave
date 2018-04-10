<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use backend\widgets\WizardMenu;
use kartik\widgets\Typeahead;
use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use andahrm\leave\models\LeaveType;
use andahrm\leave\models\PersonLeave;

$this->title = Yii::t('andahrm/leave', 'Select Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Leaves'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/leave', 'Create New'), 'url' => ['create', 'step' => 'reset']];
$this->params['breadcrumbs'][] = $this->title;


$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
$personLeave = $personLeave->position->section->leaveRelatedSection;
if ($personLeave) {
    ?>


    <?php
    echo WizardMenu::widget([
        'currentStepCssClass' => 'selected',
        'step' => $event->step,
        'wizard' => $event->sender,
        'options' => ['class' => 'wizard_steps anchor']
    ]);
    ?>


    <?php $form = ActiveForm::begin(['options' => ['data-pjax' => '']]); ?>

    <div class="x_panel tile">
        <div class="x_title">
            <h2><?= $this->title; ?></h2>
    <?php if ($model->hasErrors('leave_type_id')): ?>
                มีปัญหา
            <?php endif; ?>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">



            <table class="table">
                <thead> 
                    <tr>
                        <th width="300"><?= Yii::t('andahrm/leave', 'Title') ?></th>
                        <!--<th width="100"><?= Yii::t('andahrm/leave', 'Limit') ?></th>-->
                        <th width="250"><?= Yii::t('andahrm/leave', 'Detail') ?></th>
                        <th>หมายเหตุ</th>
                    </tr>
                </thead>
    <?php
    //$model->leave_type_id = 1;
    foreach (LeaveType::find()->all() as $type):
        //$model->leave_type_id = null;
        ?>

                    <tr>
                        <td>
        <?php #Html::activeRadio($model,'leave_type_id',['value'=>$type->id,'label'=>'&nbsp; '.$type->title,])  ?>

                            <?php
                            echo $form->field($model, 'leave_type_id')->radio([
                                'uncheck' => null,
                                'checked' => ($model->leave_type_id == $type->id),
                                'label' => '&nbsp; ' . $type->title,
                                'value' => $type->id,
                                    //'options'=>['value'=>$type->id,]
                            ])->label(false)
                            ?>
                        </td>
                        <!--<td>-->
                        <!--    <?php /* echo$type->limit?$type->limit." ".Yii::t('andahrm','Day'):'-' */ ?>-->
                        <!--</td>-->
                        <td>
        <?= $type->detail ?>
                            <?= $type->limit ? '<br/><span class="red">' . Yii::t('andahrm/leave', 'Limit') . ' ' . $type->limit . " " . Yii::t('andahrm', 'Day') . "</span>" : '-' ?>
                        </td>
                        <td>&nbsp;</td>
                    </tr>

        <?php
    endforeach;
    ?>
            </table>

    <?= $this->render('button', ['event' => $event]); ?>

            <div class="clearfix"></div>
        </div>
    </div>
    <?php
    ActiveForm::end();
}else {
    echo 'คุณยังไม่มีตำแหน่ง';
}
?>