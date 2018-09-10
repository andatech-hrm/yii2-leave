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

//$personLeave = PersonLeave::findOne(Yii::$app->user->identity->id);
//$personLeave = $personLeave->position->section->leaveRelatedSection;
//if ($personLeave) {
?>
<table class="table">
    <thead> 
        <tr>
            <th width="300"><?= Yii::t('andahrm/leave', 'Title') ?></th>
            <!--<th width="100"><?= Yii::t('andahrm/leave', 'Limit') ?></th>-->
            <th ><?= Yii::t('andahrm/leave', 'Detail') ?></th>
            <th width="200">หมายเหตุ</th>
        </tr>
    </thead>
    <?php
    //$model->leave_type_id = 1;
    foreach (LeaveType::find()->all() as $type):
        //$model->leave_type_id = null;
        ?>

        <tr>
            <td>
                <?php echo Html::a($type->title, ['draft', 'type' => $type->id], ['class' => 'btn btn-success btn-block']) ?>

                <?php
//                echo $form->field($model, 'leave_type_id')->radio([
//                    'uncheck' => null,
//                    'checked' => ($model->leave_type_id == $type->id),
//                    'label' => '&nbsp; ' . $type->title,
//                    'value' => $type->id,
//                        //'options'=>['value'=>$type->id,]
//                ])->label(false)
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

<?php
//}else {
//    echo 'คุณยังไม่มีตำแหน่ง';
//}
?>